<?php

namespace App\Http\Controllers;

use App\Models\StudentResearch;
use App\Models\ResearchAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentResearchController extends Controller
{
    public function create()
    {
        return view('student.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'department' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'research_file' => 'required|mimes:pdf|max:10240',
            'abstract' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('banners/student', 'public');
        }

        if ($request->hasFile('research_file')) {
            $data['research_file'] = $request->file('research_file')->store('research/student', 'public');
        }

        StudentResearch::create($data);

        // Always return JSON response for success
        return response()->json([
            'status' => 'success',
            'message' => 'Student research submitted successfully! It is now pending approval.'
        ]);
    }

    public function show($id)
    {
        $research = StudentResearch::with('user')->findOrFail($id);
        // Track view
        ResearchAnalytic::trackView('student', $id, request());
        // Get analytics
        $viewCount = ResearchAnalytic::getViewCount('student', $id);
        $downloadCount = ResearchAnalytic::getDownloadCount('student', $id);

        // Fetch 'Cited By' (other research that cite this one)
        $citedBy = \App\Models\ResearchCitation::where('cited_research_id', $id)
            ->where('cited_research_type', 'student')
            ->get();

        // Fetch Citations (research this item has cited)
        $citations = \App\Models\ResearchCitation::where('citing_research_type', 'student')
            ->where('citing_research_title', $research->title)
            ->get();

        return view('research.student-detail', compact('research', 'viewCount', 'downloadCount', 'citedBy', 'citations'));
    }

    public function showPublic($id)
    {
        $research = StudentResearch::with('user')->where('status', 'approved')->findOrFail($id);
        
        // Track view (even for non-authenticated users)
        ResearchAnalytic::trackView('student', $id, request());
        
        // Get analytics
        $viewCount = ResearchAnalytic::getViewCount('student', $id);
        $downloadCount = ResearchAnalytic::getDownloadCount('student', $id);
        
        return view('research.student-detail-public', compact('research', 'viewCount', 'downloadCount'));
    }

    public function downloadSurvey($id)
    {
        $research = StudentResearch::findOrFail($id);
        return view('research.download-survey', compact('research'))->render();
    }

    public function download(Request $request, $id)
    {
        if (auth()->guest()) {
            return response()->json(['error' => 'You must be logged in to download. Please log in first.'], 401);
        }
        $research = StudentResearch::findOrFail($id);
        
        if (!$research->research_file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Validate survey data
        $request->validate([
            'purpose' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        // Track download with survey data
        ResearchAnalytic::trackDownload(
            'student', 
            $id, 
            $request, 
            $request->purpose, 
            $request->notes
        );

        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $research->research_file);
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Download will start shortly',
            'download_url' => route('student.download.file', $id)
        ]);
    }

    public function downloadFile($id)
    {
        $research = StudentResearch::findOrFail($id);
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $research->research_file);
        
        return response()->download($filePath, $research->title . '.pdf');
    }

    public function edit($id)
    {
        $research = \App\Models\StudentResearch::findOrFail($id);
        if (auth()->id() !== $research->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('student.upload', [
            'research' => $research,
            'editMode' => true
        ]);
    }
}
