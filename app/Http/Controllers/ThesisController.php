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

        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thesis submitted successfully! It is now pending approval.'
            ]);
        }

        return redirect()->route('research.history')->with('success', 'Thesis submitted successfully! It is now pending approval.');
    }

    public function show($id)
    {
        $thesis = Thesis::with(['user', 'approvedBy'])->findOrFail($id);
        
        if ($thesis->status !== 'approved') {
            abort(404);
        }
        
        $thesis->incrementViews();
        
        return view('research.thesis-detail', compact('thesis'));
    }

    public function downloadSurvey($id)
    {
        $thesis = Thesis::findOrFail($id);
        return view('research.download-survey', compact('thesis'))->render();
    }

    public function download(Request $request, $id)
    {
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
}
