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
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'department' => 'required|exists:departments,id',
                'program' => 'required|exists:programs,id',
                'year_completed' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'keywords' => 'required|string',
                'document_file' => 'required|mimes:pdf|max:10240',
                'abstract_file' => 'required|mimes:pdf|max:10240',
                'abstract' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return JSON error response for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        try {
            $data = $request->all();
            $data['user_id'] = auth()->id();
            
            // Convert department and program IDs to names for compatibility
            $department = \App\Models\Department::find($request->department);
            $program = \App\Models\Program::find($request->program);
            
            $data['department'] = $department->name;
            $data['program'] = $program->name;

            if ($request->hasFile('document_file')) {
                $data['document_file'] = $request->file('document_file')->store('dissertations', 'public');
            }

            if ($request->hasFile('abstract_file')) {
                $data['abstract_file'] = $request->file('abstract_file')->store('research/abstracts', 'public');
            }

            $dissertation = Dissertation::create($data);

            // Always return JSON response for success
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Dissertation submitted successfully! It is now pending approval.',
                    'research_id' => $dissertation->id
                ]);
            }
            
            return redirect()->route('research.history')->with('success', 'Dissertation submitted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Dissertation submission error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while submitting your dissertation. Please try again.'
                ], 500);
            }
            
            return back()->withInput()->with('error', 'An error occurred while submitting your dissertation. Please try again.');
        }
    }

    public function show($id)
    {
        $dissertation = Dissertation::with(['user', 'approvedBy'])->findOrFail($id);
        
        $user = auth()->user();
        $isOwner = $dissertation->user_id === $user->id;
        
        // Check if user is admin (safely)
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            // If role check fails, just use the role property
            $isAdmin = $user->role === 'admin';
        }
        
        // Allow owner and admin to view any status
        // Others can only view approved research
        if (!$isOwner && !$isAdmin && $dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('dissertation', $id, request());
        
        // Get analytics from ResearchAnalytic (single source of truth)
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('dissertation', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('dissertation', $id);
        
        return view('research.dissertation-detail', compact('dissertation', 'viewCount', 'downloadCount'));
    }

    public function showPublic($id)
    {
        $dissertation = Dissertation::with(['user', 'approvedBy'])->where('status', 'approved')->findOrFail($id);
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('dissertation', $id, request());
        
        // Get analytics from ResearchAnalytic (single source of truth)
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
        $user = auth()->user();
        
        // Only admins can download
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            $isAdmin = $user->role === 'admin';
        }
        
        if (!$isAdmin) {
            return response()->json(['error' => 'Unauthorized. Only administrators can download documents.'], 403);
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        // Only allow download of approved research
        if ($dissertation->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
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
        $user = auth()->user();
        
        // Only admins can download
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            $isAdmin = $user->role === 'admin';
        }
        
        if (!$isAdmin) {
            abort(403, 'Unauthorized. Only administrators can download documents.');
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        // Only allow download of approved research
        if ($dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$dissertation->document_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $dissertation->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        return response()->download($filePath, ($dissertation->title ?: 'Dissertation_' . $dissertation->id) . '.pdf');
    }

    public function viewPdf($id)
    {
        $user = auth()->user();
        
        // Only admins can view PDFs
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            $isAdmin = $user->role === 'admin';
        }
        
        if (!$isAdmin) {
            abort(403, 'Unauthorized. Only administrators can view documents.');
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        if (!$dissertation->document_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $dissertation->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($dissertation->title ?: 'Dissertation_' . $dissertation->id) . '.pdf"',
        ]);
    }

    public function downloadAbstract(Request $request, $id)
    {
        $dissertation = Dissertation::findOrFail($id);
        $user = auth()->user();

        // Only allow download of approved research
        if ($dissertation->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
        }
        
        if (!$dissertation->abstract_file) {
            return response()->json(['error' => 'Abstract file not found'], 404);
        }

        // Validate survey data
        $request->validate([
            'purpose' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        // Track download with survey data
        \App\Models\ResearchAnalytic::trackDownload(
            'dissertation', 
            $id, 
            $request, 
            $request->purpose, 
            $request->notes
        );

        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $dissertation->abstract_file);
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Abstract file not found on server'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Abstract download will start shortly',
            'download_url' => route('dissertation.download-abstract.file', $id)
        ]);
    }

    public function downloadAbstractFile($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        
        // Only allow download of approved research
        if ($dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$dissertation->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $dissertation->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'Abstract file not found on server');
        }
        
        return response()->download($filePath, ($dissertation->title ?: 'Dissertation_' . $dissertation->id) . '_Abstract.pdf');
    }

    public function viewAbstractPdf($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        $user = auth()->user();
        $isOwner = $dissertation->user_id && $dissertation->user_id === $user->id;
        
        // Check if user is admin (safely)
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            $isAdmin = $user->role === 'admin';
        }
        
        // Allow owner and admin to view any status
        // Others can only view approved research
        if (!$isOwner && !$isAdmin && $dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$dissertation->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $dissertation->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'Abstract file not found on server');
        }
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($dissertation->title ?: 'Dissertation_' . $dissertation->id) . '_Abstract.pdf"',
        ]);
    }

    public function edit($id)
    {
        $dissertation = \App\Models\Dissertation::findOrFail($id);
        // Optional: Only allow the owner to edit
        if (auth()->id() !== $dissertation->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('dissertations.upload', [
            'dissertation' => $dissertation,
            'editMode' => true
        ]);
    }
}
