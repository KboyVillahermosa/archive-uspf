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
                $data['document_file'] = $request->file('document_file')->store('thesis', 'public');
            }

            if ($request->hasFile('abstract_file')) {
                $data['abstract_file'] = $request->file('abstract_file')->store('research/abstracts', 'public');
            }

            $thesis = Thesis::create($data);

            // Always return JSON response for success
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Thesis submitted successfully! It is now pending approval.',
                    'research_id' => $thesis->id
                ]);
            }
            
            return redirect()->route('research.history')->with('success', 'Thesis submitted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Thesis submission error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while submitting your thesis. Please try again.'
                ], 500);
            }
            
            return back()->withInput()->with('error', 'An error occurred while submitting your thesis. Please try again.');
        }
    }

    public function show($id)
    {
        $thesis = Thesis::with(['user', 'approvedBy'])->findOrFail($id);
        
        $user = auth()->user();
        $isOwner = $thesis->user_id === $user->id;
        
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
        if (!$isOwner && !$isAdmin && $thesis->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('thesis', $id, request());
        
        // Get analytics from ResearchAnalytic (single source of truth)
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('thesis', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('thesis', $id);
        $shareCount = 0; // Share count not implemented yet
        
        return view('research.thesis-detail', compact('thesis', 'viewCount', 'downloadCount', 'shareCount'));
    }

    public function showPublic($id)
    {
        $thesis = Thesis::with(['user', 'approvedBy'])->where('status', 'approved')->findOrFail($id);
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('thesis', $id, request());
        
        // Get analytics from ResearchAnalytic (single source of truth)
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('thesis', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('thesis', $id);
        $shareCount = 0; // Share count not implemented yet
        
        return view('research.thesis-detail', compact('thesis', 'viewCount', 'downloadCount', 'shareCount'));
    }

    public function downloadSurvey($id)
    {
        $thesis = Thesis::findOrFail($id);
        return view('research.download-survey', compact('thesis'))->render();
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
        
        $thesis = Thesis::findOrFail($id);
        
        // Only allow download of approved research
        if ($thesis->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
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
        
        $thesis = Thesis::findOrFail($id);
        
        // Only allow download of approved research
        if ($thesis->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$thesis->document_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $thesis->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        return response()->download($filePath, ($thesis->title ?: 'Thesis_' . $thesis->id) . '.pdf');
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
        
        $thesis = Thesis::findOrFail($id);
        
        if (!$thesis->document_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $thesis->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . ($thesis->title ?: 'Thesis_' . $thesis->id) . '.pdf"',
        ]);
    }

    public function downloadAbstract(Request $request, $id)
    {
        $thesis = Thesis::findOrFail($id);
        $user = auth()->user();

        // Only allow download of approved research
        if ($thesis->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
        }
        
        if (!$thesis->abstract_file) {
            return response()->json(['error' => 'Abstract file not found'], 404);
        }

        // Validate survey data
        $request->validate([
            'purpose' => 'required|string',
            'notes' => 'nullable|string|max:500'
        ]);

        // Track download with survey data
        \App\Models\ResearchAnalytic::trackDownload(
            'thesis', 
            $id, 
            $request, 
            $request->purpose, 
            $request->notes
        );

        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $thesis->abstract_file);
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Abstract file not found on server'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Abstract download will start shortly',
            'download_url' => route('thesis.download-abstract.file', $id)
        ]);
    }

    public function downloadAbstractFile($id)
    {
        $thesis = Thesis::findOrFail($id);
        
        // Only allow download of approved research
        if ($thesis->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$thesis->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $thesis->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'Abstract file not found on server');
        }
        
        return response()->download($filePath, ($thesis->title ?: 'Thesis_' . $thesis->id) . '_Abstract.pdf');
    }

    public function viewAbstractPdf($id)
    {
        $thesis = Thesis::findOrFail($id);
        $user = auth()->user();
        $isOwner = $thesis->user_id && $thesis->user_id === $user->id;
        
        // Check if user is admin (safely)
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            $isAdmin = $user->role === 'admin';
        }
        
        // Allow owner and admin to view any status
        // Others can only view approved research
        if (!$isOwner && !$isAdmin && $thesis->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$thesis->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $thesis->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'Abstract file not found on server');
        }
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $thesis->abstract_file);
        $backUrl = route('thesis.show.public', $thesis->id);
        $downloadUrl = route('thesis.download-abstract', $thesis->id);
        
        return view('pdf.viewer', [
            'title' => 'Abstract PDF',
            'subtitle' => $thesis->title ?: 'Thesis_' . $thesis->id,
            'pdfUrl' => $pdfUrl,
            'backUrl' => $backUrl,
            'downloadUrl' => $downloadUrl,
        ]);
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
