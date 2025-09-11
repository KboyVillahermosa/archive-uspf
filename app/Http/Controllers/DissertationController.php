<?php

namespace App\Http\Controllers;

use App\Models\Dissertation;
use App\Models\ResearchAnalytic;
use Illuminate\Http\Request;

class DissertationController extends Controller
{
    public function create()
    {
        return view('dissertations.upload');
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
            $data['document_file'] = $request->file('document_file')->store('dissertations', 'public');
        }

        Dissertation::create($data);

        // Always return JSON response for success
        return response()->json([
            'status' => 'success',
            'message' => 'Dissertation submitted successfully! It is now pending approval.'
        ]);
    }

    public function show($id)
    {
        $dissertation = Dissertation::with(['user', 'approvedBy'])->findOrFail($id);
        
        if ($dissertation->status !== 'approved') {
            abort(404);
        }
        
        // Track view
        \App\Models\ResearchAnalytic::trackView('dissertation', $id, request());
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('dissertation', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('dissertation', $id);
        
        return view('research.dissertation-detail', compact('dissertation', 'viewCount', 'downloadCount'));
    }

    public function showPublic($id)
    {
        $dissertation = Dissertation::with(['user', 'approvedBy'])->where('status', 'approved')->findOrFail($id);
        
        // Track view
        \App\Models\ResearchAnalytic::trackView('dissertation', $id, request());
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('dissertation', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('dissertation', $id);
        
        return view('research.dissertation-detail', compact('dissertation', 'viewCount', 'downloadCount'));
    }

    public function downloadSurvey($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        return view('research.download-survey', compact('dissertation'))->render();
    }

    public function download(Request $request, $id)
    {
        if (auth()->guest()) {
            return response()->json(['error' => 'You must be logged in to download. Please log in first.'], 401);
        }
        $dissertation = Dissertation::findOrFail($id);
        
        if ($dissertation->status !== 'approved') {
            return response()->json(['error' => 'Not available'], 404);
        }

        if (!$dissertation->document_file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $request->validate([
            'purpose' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        ResearchAnalytic::trackDownload('dissertation', $id, $request, $request->purpose, $request->notes);

        $filePath = storage_path('app/public/' . $dissertation->document_file);
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Download will start shortly',
            'download_url' => route('dissertation.download.file', $id)
        ]);
    }

    public function downloadFile($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        $filePath = storage_path('app/public/' . $dissertation->document_file);
        return response()->download($filePath, ($dissertation->title ?: 'Dissertation_' . $dissertation->id) . '.pdf');
    }
}
