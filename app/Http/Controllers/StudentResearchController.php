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
        $this->authorize('create', StudentResearch::class);
        return view('student.upload');
    }

    public function store(Request $request)
    {
        $this->authorize('create', StudentResearch::class);
        
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'authors' => 'required|string',
                'department' => 'required|exists:departments,id',
                'program' => 'required|exists:programs,id',
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
            
            // Convert department and program IDs to names for compatibility
            $department = \App\Models\Department::find($request->department);
            $program = \App\Models\Program::find($request->program);
            
            $data['department'] = $department->name;
            $data['program'] = $program->name;

            if ($request->hasFile('banner_image')) {
                $data['banner_image'] = $request->file('banner_image')->store('banners/student', 'public');
            }

            if ($request->hasFile('research_file')) {
                $data['research_file'] = $request->file('research_file')->store('research/student', 'public');
            }

            $research = StudentResearch::create($data);

            // Always return JSON response for AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Student research submitted successfully! It is now pending approval.',
                    'research_id' => $research->id
                ]);
            }
            
            // For non-AJAX requests, redirect with success message
            return redirect()->route('research.history')->with('success', 'Student research submitted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Student research submission error: ' . $e->getMessage());
            
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
        $research = StudentResearch::with('user')->findOrFail($id);
        $this->authorize('view', $research);
        
        // If not admin and not owner, only show approved research
        if (!$research->user || (auth()->id() !== $research->user_id && !auth()->user()->hasRole('admin'))) {
            if ($research->status !== 'approved') {
                abort(404);
            }
        }
        
        // Track view
        ResearchAnalytic::trackView('student', $id, request());
        
        // Get analytics
        $viewCount = ResearchAnalytic::getViewCount('student', $id);
        $downloadCount = ResearchAnalytic::getDownloadCount('student', $id);
        
        return view('research.student-detail', compact('research', 'viewCount', 'downloadCount'));
    }

    public function showPublic($id)
    {
        $research = StudentResearch::with('user')->where('status', 'approved')->findOrFail($id);
        
        // Track view (even for non-authenticated users)
        ResearchAnalytic::trackView('student', $id, request());
        
        // Get analytics
        $viewCount = ResearchAnalytic::getViewCount('student', $id);
        $downloadCount = ResearchAnalytic::getDownloadCount('student', $id);
        
        return view('research.student-detail', compact('research', 'viewCount', 'downloadCount'));
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
        $this->authorize('update', $research);
        return view('student.upload', [
            'research' => $research,
            'editMode' => true
        ]);
    }
}
