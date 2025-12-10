<?php

namespace App\Http\Controllers;

use App\Models\FacultyResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacultyResearchController extends Controller
{
    public function create()
    {
        $this->authorize('create', FacultyResearch::class);
        return view('faculty.upload');
    }

    public function store(Request $request)
    {
        $this->authorize('create', FacultyResearch::class);
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'co_researchers' => 'nullable|string',
                'department' => 'required|exists:departments,id',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'research_file' => 'required|mimes:pdf|max:10240',
                'abstract' => 'required|string',
                'tags' => 'nullable|string',
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
            
            // Convert department ID to name for compatibility
            $department = \App\Models\Department::find($request->department);
            $data['department'] = $department->name;

            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $request->file('banner_image')->store('banners/faculty', 'public');
            }

            if ($request->hasFile('research_file')) {
                $data['research_file'] = $request->file('research_file')->store('research/faculty', 'public');
            }

            $research = FacultyResearch::create($data);

            // Always return JSON response for success
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Faculty research submitted successfully! It is now pending approval.',
                    'research_id' => $research->id
                ]);
            }
            
            return redirect()->route('research.history')->with('success', 'Faculty research submitted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Faculty research submission error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while submitting your research. Please try again.'
                ], 500);
            }
            
            return back()->withInput()->with('error', 'An error occurred while submitting your research. Please try again.');
        }
    }

    public function show($id)
    {
        $research = FacultyResearch::with(['user', 'approvedBy'])->findOrFail($id);
        $this->authorize('view', $research);
        
        // If not admin, only show approved research
        if (!$research->user || (auth()->id() !== $research->user_id && !auth()->user()->hasRole('admin'))) {
            if ($research->status !== 'approved') {
                abort(404);
            }
        }
        
        $research->incrementViews();
        
        // Get analytics
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('faculty', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('faculty', $id);
        
        return view('research.faculty-detail', compact('research', 'viewCount', 'downloadCount'));
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
        $research = FacultyResearch::findOrFail($id);
        
        // Only allow download of approved research
        if ($research->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
        }
        
        if (!$research->research_file) {
            return response()->json(['error' => 'File not found'], 404);
        }
        
        // Validate survey data if provided
        if ($request->has('purpose')) {
            $request->validate([
                'purpose' => 'required|string',
                'notes' => 'nullable|string|max:500'
            ]);
            
            // Track download with survey data
            \App\Models\ResearchAnalytic::trackDownload(
                'faculty', 
                $id, 
                $request, 
                $request->purpose, 
                $request->notes
            );
        } else {
            // Track download without survey data
            \App\Models\ResearchAnalytic::trackDownload('faculty', $id, $request);
        }
        
        $filePath = storage_path('app/public/' . $research->research_file);
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server'], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Download will start shortly',
            'download_url' => route('faculty.download.file', $id)
        ]);
        }
    
    public function downloadFile($id)
    {
        $research = FacultyResearch::findOrFail($id);
        
        // Only allow download of approved research
        if ($research->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$research->research_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $research->research_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        return response()->download($filePath, 'Faculty_Research_' . $research->id . '.pdf');
    }

    public function edit($id)
    {
        $research = \App\Models\FacultyResearch::findOrFail($id);
        $this->authorize('update', $research);
        return view('faculty.upload', [
            'research' => $research,
            'editMode' => true
        ]);
    }
}
