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
        
        // Get related research
        $relatedResearch = $this->getRelatedResearch($dissertation);
        
        return view('research.dissertation-detail', compact('dissertation', 'viewCount', 'downloadCount', 'relatedResearch'));
    }

    private function getRelatedResearch($currentDissertation)
    {
        $related = collect();
        
        // Extract keywords from current dissertation
        $keywords = [];
        if ($currentDissertation->keywords) {
            $keywords = array_map('trim', explode(',', $currentDissertation->keywords));
            $keywords = array_filter($keywords, function($k) {
                return !empty($k);
            });
        }
        
        // If no keywords, return empty collection
        if (empty($keywords)) {
            return $related;
        }
        
        $currentDepartment = $currentDissertation->department;
        $currentTitleWords = array_map('strtolower', explode(' ', $currentDissertation->title));
        
        // Query Student Research
        $studentResearch = \App\Models\StudentResearch::where('status', 'approved')
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('tags', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->get();
        
        foreach ($studentResearch as $item) {
            $score = $this->calculateRelevanceScore($item, $keywords, $currentDepartment, $currentTitleWords, 'tags');
            $related->push([
                'id' => $item->id,
                'type' => 'Student Research',
                'title' => $item->title,
                'author' => $item->authors,
                'department' => $item->department,
                'route' => 'student.show.public',
                'researchType' => 'student',
                'viewCount' => \App\Models\ResearchAnalytic::getViewCount('student', $item->id),
                'downloadCount' => \App\Models\ResearchAnalytic::getDownloadCount('student', $item->id),
                'score' => $score
            ]);
        }
        
        // Query Faculty Research
        $facultyResearch = \App\Models\FacultyResearch::where('status', 'approved')
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('tags', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->get();
        
        foreach ($facultyResearch as $item) {
            $score = $this->calculateRelevanceScore($item, $keywords, $currentDepartment, $currentTitleWords, 'tags');
            $related->push([
                'id' => $item->id,
                'type' => 'Faculty Research',
                'title' => $item->title,
                'author' => $item->user->name ?? ($item->co_researchers ?? 'N/A'),
                'department' => $item->department,
                'route' => 'faculty.show.public',
                'researchType' => 'faculty',
                'viewCount' => \App\Models\ResearchAnalytic::getViewCount('faculty', $item->id),
                'downloadCount' => \App\Models\ResearchAnalytic::getDownloadCount('faculty', $item->id),
                'score' => $score
            ]);
        }
        
        // Query Thesis
        $theses = \App\Models\Thesis::where('status', 'approved')
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('keywords', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->get();
        
        foreach ($theses as $item) {
            $score = $this->calculateRelevanceScore($item, $keywords, $currentDepartment, $currentTitleWords, 'keywords');
            $related->push([
                'id' => $item->id,
                'type' => 'Thesis',
                'title' => $item->title,
                'author' => $item->author,
                'department' => $item->department,
                'route' => 'thesis.show.public',
                'researchType' => 'thesis',
                'viewCount' => \App\Models\ResearchAnalytic::getViewCount('thesis', $item->id),
                'downloadCount' => \App\Models\ResearchAnalytic::getDownloadCount('thesis', $item->id),
                'score' => $score
            ]);
        }
        
        // Query Dissertation
        $dissertations = Dissertation::where('status', 'approved')
            ->where('id', '!=', $currentDissertation->id)
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('keywords', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->get();
        
        foreach ($dissertations as $item) {
            $score = $this->calculateRelevanceScore($item, $keywords, $currentDepartment, $currentTitleWords, 'keywords');
            $related->push([
                'id' => $item->id,
                'type' => 'Dissertation',
                'title' => $item->title,
                'author' => $item->author,
                'department' => $item->department,
                'route' => 'dissertation.show.public',
                'researchType' => 'dissertation',
                'viewCount' => \App\Models\ResearchAnalytic::getViewCount('dissertation', $item->id),
                'downloadCount' => \App\Models\ResearchAnalytic::getDownloadCount('dissertation', $item->id),
                'score' => $score
            ]);
        }
        
        // Sort by score and return top 6
        return $related->sortByDesc('score')->take(6)->values();
    }

    private function calculateRelevanceScore($item, $keywords, $currentDepartment, $currentTitleWords, $keywordField)
    {
        $score = 0;
        
        // Count matching keywords
        $itemKeywords = [];
        if ($item->$keywordField) {
            $itemKeywords = array_map('trim', explode(',', $item->$keywordField));
            $itemKeywords = array_map('strtolower', $itemKeywords);
        }
        
        foreach ($keywords as $keyword) {
            if (in_array(strtolower(trim($keyword)), $itemKeywords)) {
                $score += 2;
            }
        }
        
        // Bonus for same department
        if ($item->department && strtolower($item->department) === strtolower($currentDepartment)) {
            $score += 3;
        }
        
        // Bonus for title word similarity
        $itemTitleWords = array_map('strtolower', explode(' ', $item->title));
        $commonWords = array_intersect($currentTitleWords, $itemTitleWords);
        // Remove common words like "the", "a", "an", "of", "in", "on", "at", "to", "for"
        $stopWords = ['the', 'a', 'an', 'of', 'in', 'on', 'at', 'to', 'for', 'and', 'or', 'but'];
        $commonWords = array_filter($commonWords, function($word) use ($stopWords) {
            return !in_array($word, $stopWords) && strlen($word) > 2;
        });
        $score += count($commonWords);
        
        return $score;
    }

    public function downloadSurvey($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        return view('research.download-survey', compact('dissertation'))->render();
    }

    public function downloadAbstractGet($id)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download abstract PDFs.');
        }
        
        // If authenticated, redirect to research detail page where download modal can be opened
        return redirect()->route('dissertation.show.public', $id)->with('open_download_modal', true);
    }

    public function download(Request $request, $id)
    {
        // Require authentication for full document downloads
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to download full documents.', 'login_required' => true], 401);
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
        // Require authentication for full document downloads
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download full documents.');
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        // Allow owner and admin to download any status
        // Others can only download approved research
        $user = auth()->user();
        $isOwner = $dissertation->user_id === $user->id;
        $isAdmin = false;
        try {
            $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        } catch (\Exception $e) {
            $isAdmin = $user->role === 'admin';
        }
        
        if (!$isOwner && !$isAdmin && $dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$dissertation->document_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $dissertation->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        // Track download (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackDownload('dissertation', $id, request(), null, null);
        
        return response()->download($filePath, ($dissertation->title ?: 'Dissertation_' . $dissertation->id) . '.pdf');
    }

    public function viewPdf($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        
        // Allow owner and admin to view any status
        // Others can only view approved research
        $user = auth()->user();
        $isOwner = $user && $dissertation->user_id === $user->id;
        $isAdmin = false;
        if ($user) {
            try {
                $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
            } catch (\Exception $e) {
                $isAdmin = $user->role === 'admin';
            }
        }
        
        if (!$isOwner && !$isAdmin && $dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$dissertation->document_file) {
            abort(404, 'File not found');
        }
        
        $filePath = storage_path('app/public/' . $dissertation->document_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server');
        }
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('dissertation', $id, request());
        
        // Check if user is authenticated
        $isAuthenticated = auth()->check();
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $dissertation->document_file);
        $backUrl = route('dissertation.show.public', $dissertation->id);
        $downloadUrl = route('dissertation.download-survey', $dissertation->id);
        
        return view('pdf.viewer', [
            'title' => 'Full Document PDF',
            'subtitle' => $dissertation->title ?: 'Dissertation_' . $dissertation->id,
            'pdfUrl' => $pdfUrl,
            'backUrl' => $backUrl,
            'downloadUrl' => $downloadUrl,
            'isAuthenticated' => $isAuthenticated,
            'blurred' => !$isAuthenticated, // Blur if not authenticated
        ]);
    }

    public function downloadAbstract(Request $request, $id)
    {
        // Require authentication for abstract PDF downloads
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to download abstract PDFs.', 'login_required' => true], 401);
        }
        
        $dissertation = Dissertation::findOrFail($id);

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
        // Require authentication for abstract PDF downloads
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download abstract PDFs.');
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        // Only allow download of approved research
        if ($dissertation->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$dissertation->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Track download (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackDownload('dissertation', $id, request(), null, null);
        
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
        
        // Only allow viewing of approved research abstracts
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
        
        // Check if user is authenticated
        $isAuthenticated = auth()->check();
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $dissertation->abstract_file);
        $backUrl = route('dissertation.show.public', $dissertation->id);
        $downloadUrl = route('dissertation.download-abstract.get', $dissertation->id);
        
        return view('pdf.viewer', [
            'title' => 'Abstract PDF',
            'subtitle' => $dissertation->title ?: 'Dissertation_' . $dissertation->id,
            'pdfUrl' => $pdfUrl,
            'backUrl' => $backUrl,
            'downloadUrl' => $downloadUrl,
            'isAuthenticated' => $isAuthenticated,
            'blurred' => !$isAuthenticated, // Blur if not authenticated
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
