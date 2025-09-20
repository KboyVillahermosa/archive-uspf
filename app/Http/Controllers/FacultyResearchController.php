<?php

namespace App\Http\Controllers;

use App\Models\FacultyResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacultyResearchController extends Controller
{
    public function create()
    {
        return view('faculty.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'co_researchers' => 'nullable|string',
            'department' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'research_file' => 'required|mimes:pdf|max:10240',
            'abstract' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('banners/faculty', 'public');
        }

        if ($request->hasFile('research_file')) {
            $data['research_file'] = $request->file('research_file')->store('research/faculty', 'public');
        }

        FacultyResearch::create($data);

        // Always return JSON response for success
        return response()->json([
            'status' => 'success',
            'message' => 'Faculty research submitted successfully! It is now pending approval.'
        ]);
    }

    public function show($id)
    {
        $research = FacultyResearch::with(['user', 'approvedBy'])->findOrFail($id);
        if ($research->status !== 'approved') {
            abort(404);
        }
        $research->incrementViews();
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('faculty', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('faculty', $id);

        // Fetch 'Cited By' (other research that cite this one)
        $citedBy = \App\Models\ResearchCitation::where('cited_research_id', $id)
            ->where('cited_research_type', 'faculty')
            ->get();

        // Fetch Citations (research this item has cited)
        $citations = \App\Models\ResearchCitation::where('citing_research_type', 'faculty')
            ->where('citing_research_title', $research->title)
            ->get();

        return view('research.faculty-detail', compact('research', 'viewCount', 'downloadCount', 'citedBy', 'citations'));
    }

    public function showPublic($id)
    {
        $research = FacultyResearch::with(['user', 'approvedBy'])->where('status', 'approved')->findOrFail($id);
        
        $research->incrementViews();
        
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('faculty', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('faculty', $id);
        
        return view('research.faculty-detail', compact('research', 'viewCount', 'downloadCount'));
    }

    public function download(Request $request, $id)
    {
        if (auth()->guest()) {
            return response()->json(['error' => 'You must be logged in to download. Please log in first.'], 401);
        }
        $research = FacultyResearch::findOrFail($id);
        
        if ($research->status !== 'approved') {
            abort(404);
        }
        
        $filePath = storage_path('app/public/' . $research->research_file);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->download($filePath, 'Faculty_Research_' . $research->id . '.pdf');
    }

    public function edit($id)
    {
        $research = \App\Models\FacultyResearch::findOrFail($id);
        if (auth()->id() !== $research->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('faculty.upload', [
            'research' => $research,
            'editMode' => true
        ]);
    }
}
