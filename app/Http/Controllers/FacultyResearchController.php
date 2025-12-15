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
                'abstract_file' => 'required|mimes:pdf|max:10240',
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

            if ($request->hasFile('abstract_file')) {
                $data['abstract_file'] = $request->file('abstract_file')->store('research/abstracts', 'public');
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
        
        $user = auth()->user();
        $isOwner = $research->user_id === $user->id;
        $isAdmin = $user->hasRole('admin');
        
        // Allow owner and admin to view any status
        // Others can only view approved research
        if (!$isOwner && !$isAdmin && $research->status !== 'approved') {
            abort(404, 'Research not found or not available');
            }
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('faculty', $id, request());
        
        // Get analytics from ResearchAnalytic (single source of truth)
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('faculty', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('faculty', $id);
        
        return view('research.faculty-detail', compact('research', 'viewCount', 'downloadCount'));
    }

    public function showPublic($id)
    {
        $research = FacultyResearch::with(['user', 'approvedBy'])->where('status', 'approved')->findOrFail($id);
        
        // Track view (single source of truth - ResearchAnalytic)
        \App\Models\ResearchAnalytic::trackView('faculty', $id, request());
        
        // Get analytics from ResearchAnalytic (single source of truth)
        $viewCount = \App\Models\ResearchAnalytic::getViewCount('faculty', $id);
        $downloadCount = \App\Models\ResearchAnalytic::getDownloadCount('faculty', $id);
        
        // Get related research
        $relatedResearch = $this->getRelatedResearch($research);
        
        return view('research.faculty-detail', compact('research', 'viewCount', 'downloadCount', 'relatedResearch'));
    }

    private function getRelatedResearch($currentResearch)
    {
        $related = collect();
        
        // Extract keywords from current research
        $keywords = [];
        if ($currentResearch->tags) {
            $keywords = array_map('trim', explode(',', $currentResearch->tags));
            $keywords = array_filter($keywords, function($k) {
                return !empty($k);
            });
        }
        
        // If no keywords, return empty collection
        if (empty($keywords)) {
            return $related;
        }
        
        $currentDepartment = $currentResearch->department;
        $currentTitleWords = array_map('strtolower', explode(' ', $currentResearch->title));
        
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
        $facultyResearch = FacultyResearch::where('status', 'approved')
            ->where('id', '!=', $currentResearch->id)
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
        $dissertations = \App\Models\Dissertation::where('status', 'approved')
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

    public function downloadAbstractGet($id)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download abstract PDFs.');
        }
        
        // If authenticated, redirect to research detail page where download modal can be opened
        return redirect()->route('faculty.show.public', $id)->with('open_download_modal', true);
    }

    public function download(Request $request, $id)
    {
        // Require authentication for full document downloads
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to download full documents.', 'login_required' => true], 401);
        }
        
        $research = FacultyResearch::findOrFail($id);
        
        // Only allow download of approved research
        if ($research->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
        }
        
        if (!$research->research_file) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Validate survey data
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
        // Require authentication for full document downloads
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download full documents.');
        }
        
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

    public function viewPdf($id)
    {
        $research = FacultyResearch::findOrFail($id);
        
        // Only allow viewing of approved research
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
        
        // Check if user is authenticated
        $isAuthenticated = auth()->check();
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $research->research_file);
        $backUrl = route('faculty.show.public', $research->id);
        $downloadUrl = route('faculty.download-survey', $research->id);
        
        return view('pdf.viewer', [
            'title' => 'Full Document PDF',
            'subtitle' => $research->title ?: 'Faculty_Research_' . $research->id,
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
        
        $research = FacultyResearch::findOrFail($id);

        // Only allow download of approved research
        if ($research->status !== 'approved') {
            return response()->json(['error' => 'This research is not available for download'], 404);
        }
        
        if (!$research->abstract_file) {
            return response()->json(['error' => 'Abstract file not found'], 404);
        }

        // Validate survey data
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

        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $research->abstract_file);
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Abstract file not found on server'], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Abstract download will start shortly',
            'download_url' => route('faculty.download-abstract.file', $id)
        ]);
    }

    public function downloadAbstractFile($id)
    {
        // Require authentication for abstract PDF downloads
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download abstract PDFs.');
        }
        
        $research = FacultyResearch::findOrFail($id);
        
        // Only allow download of approved research
        if ($research->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$research->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $research->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'Abstract file not found on server');
        }
        
        return response()->download($filePath, ($research->title ?: 'Faculty_Research_' . $research->id) . '_Abstract.pdf');
    }

    public function viewAbstractPdf($id)
    {
        $research = FacultyResearch::findOrFail($id);
        
        // Only allow viewing of approved research abstracts
        if ($research->status !== 'approved') {
            abort(404, 'Research not found or not available');
        }
        
        if (!$research->abstract_file) {
            abort(404, 'Abstract file not found');
        }
        
        // Files are stored on the public disk (storage/app/public)
        $filePath = storage_path('app/public/' . $research->abstract_file);
        
        if (!file_exists($filePath)) {
            abort(404, 'Abstract file not found on server');
        }
        
        // Check if user is authenticated
        $isAuthenticated = auth()->check();
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $research->abstract_file);
        $backUrl = route('faculty.show.public', $research->id);
        $downloadUrl = route('faculty.download-abstract.get', $research->id);
        
        return view('pdf.viewer', [
            'title' => 'Abstract PDF',
            'subtitle' => $research->title ?: 'Faculty_Research_' . $research->id,
            'pdfUrl' => $pdfUrl,
            'backUrl' => $backUrl,
            'downloadUrl' => $downloadUrl,
            'isAuthenticated' => $isAuthenticated,
            'blurred' => !$isAuthenticated, // Blur if not authenticated
        ]);
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
