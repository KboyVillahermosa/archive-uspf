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
        
        // Get related research
        $relatedResearch = $this->getRelatedResearch($thesis);
        
        return view('research.thesis-detail', compact('thesis', 'viewCount', 'downloadCount', 'shareCount', 'relatedResearch'));
    }

    private function getRelatedResearch($currentThesis)
    {
        $related = collect();
        
        // Extract keywords from current thesis
        $keywords = [];
        if ($currentThesis->keywords) {
            $keywords = array_map('trim', explode(',', $currentThesis->keywords));
            $keywords = array_filter($keywords, function($k) {
                return !empty($k);
            });
        }
        
        // If no keywords, return empty collection
        if (empty($keywords)) {
            return $related;
        }
        
        $currentDepartment = $currentThesis->department;
        $currentTitleWords = array_map('strtolower', explode(' ', $currentThesis->title));
        
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
        $theses = Thesis::where('status', 'approved')
            ->where('id', '!=', $currentThesis->id)
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

    public function downloadSurvey($id)
    {
        $thesis = Thesis::findOrFail($id);
        return view('research.download-survey', compact('thesis'))->render();
    }

    public function downloadAbstractGet($id)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download abstract PDFs.');
        }
        
        // If authenticated, redirect to research detail page where download modal can be opened
        return redirect()->route('thesis.show.public', $id)->with('open_download_modal', true);
    }

    public function download(Request $request, $id)
    {
        // Require authentication for full document downloads
        if (!auth()->check()) {
            return response()->json(['error' => 'Please login to download full documents.', 'login_required' => true], 401);
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
        // Require authentication for full document downloads
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download full documents.');
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
        $thesis = Thesis::findOrFail($id);
        
        // Only allow viewing of approved research
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
        
        // Check if user is authenticated
        $isAuthenticated = auth()->check();
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $thesis->document_file);
        $backUrl = route('thesis.show.public', $thesis->id);
        $downloadUrl = route('thesis.download-survey', $thesis->id);
        
        return view('pdf.viewer', [
            'title' => 'Full Document PDF',
            'subtitle' => $thesis->title ?: 'Thesis_' . $thesis->id,
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
        
        $thesis = Thesis::findOrFail($id);

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
        // Require authentication for abstract PDF downloads
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to download abstract PDFs.');
        }
        
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
        
        // Only allow viewing of approved research abstracts
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
        
        // Check if user is authenticated
        $isAuthenticated = auth()->check();
        
        // Generate PDF URL for embedding
        $pdfUrl = asset('storage/' . $thesis->abstract_file);
        $backUrl = route('thesis.show.public', $thesis->id);
        $downloadUrl = route('thesis.download-abstract.get', $thesis->id);
        
        return view('pdf.viewer', [
            'title' => 'Abstract PDF',
            'subtitle' => $thesis->title ?: 'Thesis_' . $thesis->id,
            'pdfUrl' => $pdfUrl,
            'backUrl' => $backUrl,
            'downloadUrl' => $downloadUrl,
            'isAuthenticated' => $isAuthenticated,
            'blurred' => !$isAuthenticated, // Blur if not authenticated
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
