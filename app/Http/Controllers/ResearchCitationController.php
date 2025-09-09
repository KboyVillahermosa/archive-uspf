<?php

namespace App\Http\Controllers;

use App\Models\ResearchCitation;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchCitationController extends Controller
{
    public function searchApprovedResearch(Request $request)
    {
        $query = $request->get('q', '');
        $results = [];

        if (strlen($query) >= 2) {
            // Search in approved student research
            $studentResearch = StudentResearch::where('status', 'approved')
                ->where('title', 'LIKE', "%{$query}%")
                ->select('id', 'title', 'authors')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'student',
                        'title' => $item->title,
                        'authors' => $item->authors,
                        'display' => $item->title . ' - ' . $item->authors
                    ];
                });

            // Search in approved faculty research
            $facultyResearch = FacultyResearch::where('status', 'approved')
                ->where('title', 'LIKE', "%{$query}%")
                ->select('id', 'title', 'co_researchers')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'faculty',
                        'title' => $item->title,
                        'authors' => $item->co_researchers,
                        'display' => $item->title . ' - ' . $item->co_researchers
                    ];
                });

            // Search in approved thesis
            $thesis = Thesis::where('status', 'approved')
                ->where('title', 'LIKE', "%{$query}%")
                ->select('id', 'title', 'author')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'thesis',
                        'title' => $item->title,
                        'authors' => $item->author,
                        'display' => $item->title . ' - ' . $item->author
                    ];
                });

            // Search in approved dissertations
            $dissertations = Dissertation::where('status', 'approved')
                ->where('title', 'LIKE', "%{$query}%")
                ->select('id', 'title', 'author')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'type' => 'dissertation',
                        'title' => $item->title,
                        'authors' => $item->author,
                        'display' => $item->title . ' - ' . $item->author
                    ];
                });

            $results = $studentResearch->concat($facultyResearch)
                ->concat($thesis)
                ->concat($dissertations)
                ->sortBy('title')
                ->take(10);
        }

        return response()->json($results);
    }

    public function store(Request $request)
    {
        $request->validate([
            'citing_research_title' => 'required|string|max:255',
            'citing_research_type' => 'required|in:student,faculty,thesis,dissertation',
            'cited_research_id' => 'required|integer',
            'cited_research_type' => 'required|in:student,faculty,thesis,dissertation',
            'citation_context' => 'nullable|string|max:500'
        ]);

        // Check if citation already exists
        $existingCitation = ResearchCitation::where([
            'citing_user_id' => Auth::id(),
            'citing_research_title' => $request->citing_research_title,
            'cited_research_id' => $request->cited_research_id,
            'cited_research_type' => $request->cited_research_type
        ])->first();

        if ($existingCitation) {
            return response()->json([
                'status' => 'error',
                'message' => 'This research is already cited in your project.'
            ]);
        }

        ResearchCitation::create([
            'citing_user_id' => Auth::id(),
            'citing_research_title' => $request->citing_research_title,
            'citing_research_type' => $request->citing_research_type,
            'cited_research_id' => $request->cited_research_id,
            'cited_research_type' => $request->cited_research_type,
            'citation_context' => $request->citation_context
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Research citation added successfully!'
        ]);
    }

    public function getUserCitations(Request $request)
    {
        $query = ResearchCitation::where('citing_user_id', Auth::id())
            ->with('citingUser');

        // If filtering by specific research title
        if ($request->has('filter') && strpos($request->filter, 'citing_research_title:') === 0) {
            $title = urldecode(substr($request->filter, 23)); // Remove 'citing_research_title:' prefix
            $query->where('citing_research_title', $title);
        }

        $citations = $query->latest()
            ->get()
            ->map(function ($citation) {
                $citedResearch = $citation->getCitedResearch();
                return [
                    'id' => $citation->id,
                    'citing_title' => $citation->citing_research_title,
                    'citing_type' => $citation->citing_research_type,
                    'cited_title' => $citedResearch ? $citedResearch->title : 'Research not found',
                    'cited_type' => $citation->cited_research_type,
                    'cited_authors' => $this->getResearchAuthors($citedResearch, $citation->cited_research_type),
                    'citation_context' => $citation->citation_context,
                    'created_at' => $citation->created_at->format('M d, Y')
                ];
            });

        return response()->json($citations);
    }

    public function getResearchCitations($type, $id)
    {
        $citations = ResearchCitation::where('cited_research_id', $id)
            ->where('cited_research_type', $type)
            ->with('citingUser')
            ->latest()
            ->get()
            ->map(function ($citation) {
                return [
                    'citing_title' => $citation->citing_research_title,
                    'citing_type' => $citation->citing_research_type,
                    'citing_user' => $citation->citingUser->name,
                    'citation_context' => $citation->citation_context,
                    'created_at' => $citation->created_at->format('M d, Y')
                ];
            });

        return response()->json($citations);
    }

    private function getResearchAuthors($research, $type)
    {
        if (!$research) return 'Unknown';
        
        switch ($type) {
            case 'student':
                return $research->authors ?? 'Unknown';
            case 'faculty':
                return $research->user->name ?? 'Unknown';
            case 'thesis':
            case 'dissertation':
                return $research->author ?? 'Unknown';
            default:
                return 'Unknown';
        }
    }
}
