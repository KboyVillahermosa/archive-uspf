<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use App\Models\ResearchAnalytic;
use Illuminate\Http\Request;

class ThesisController extends Controller
{
    public function create()
    {
        return view('thesis.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'year_completed' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'keywords' => 'required|string',
            'document_file' => 'required|mimes:pdf|max:10240',
            'abstract' => 'required|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('document_file')) {
            $data['document_file'] = $request->file('document_file')->store('thesis', 'public');
        }

        Thesis::create($data);

        // Always return JSON response for success
        return response()->json([
            'status' => 'success',
            'message' => 'Thesis submitted successfully! It is now pending approval.'
        ]);
    }

    public function show($id)
    {
        $thesis = Thesis::with(['user', 'approvedBy'])->findOrFail($id);
        if ($thesis->status !== 'approved') {
            abort(404);
        }
        // Track view
        \App\Models\ResearchAnalytic::trackView('thesis', $id, request());
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('thesis', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('thesis', $id);

        // Fetch 'Cited By' (other research that cite this one)
        $citedBy = \App\Models\ResearchCitation::where('cited_research_id', $id)
            ->where('cited_research_type', 'thesis')
            ->get();

        // Fetch Citations (research this item has cited)
        $citations = \App\Models\ResearchCitation::where('citing_research_type', 'thesis')
            ->where('citing_research_title', $thesis->title)
            ->get();

        return view('research.thesis-detail', compact('thesis', 'viewCount', 'downloadCount', 'citedBy', 'citations'));
    }

    public function showPublic($id)
    {
        $thesis = Thesis::with(['user', 'approvedBy'])->where('status', 'approved')->findOrFail($id);
        
        // Track view
        \App\Models\ResearchAnalytic::trackView('thesis', $id, request());
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('thesis', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('thesis', $id);
        
        return view('research.thesis-detail', compact('thesis', 'viewCount', 'downloadCount'));
    }

    public function downloadSurvey($id)
    {
        $thesis = Thesis::findOrFail($id);
        return view('research.download-survey', compact('thesis'))->render();
    }

    public function download(Request $request, $id)
    {
        if (auth()->guest()) {
            return response()->json(['error' => 'You must be logged in to download. Please log in first.'], 401);
        }
        $thesis = Thesis::findOrFail($id);
        
        if ($thesis->status !== 'approved') {
            return response()->json(['error' => 'Not available'], 404);
        }

        if (!$thesis->document_file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $request->validate([
            'purpose' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        ResearchAnalytic::trackDownload('thesis', $id, $request, $request->purpose, $request->notes);

        $filePath = storage_path('app/public/' . $thesis->document_file);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Download will start shortly',
            'download_url' => route('thesis.download.file', $id)
        ]);
    }

    public function downloadFile($id)
    {
        $thesis = Thesis::findOrFail($id);
        $filePath = storage_path('app/public/' . $thesis->document_file);
        return response()->download($filePath, ($thesis->title ?: 'Thesis_' . $thesis->id) . '.pdf');
    }

    public function edit($id)
    {
        $thesis = \App\Models\Thesis::findOrFail($id);
        if (auth()->id() !== $thesis->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('thesis.upload', [
            'thesis' => $thesis,
            'editMode' => true
        ]);
    }
}
