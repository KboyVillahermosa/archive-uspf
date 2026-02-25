<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Models\ResearchAnalytic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index(Request $request)
    {
        // Redirect admin users to admin dashboard
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Get search query
        $searchQuery = $request->get('search', '');
        
        // Build base queries
        $studentQuery = StudentResearch::where('status', 'approved')->with('user');
        $facultyQuery = FacultyResearch::where('status', 'approved')->with('user');
        $thesisQuery = Thesis::where('status', 'approved')->with('user');
        $dissertationQuery = Dissertation::where('status', 'approved')->with('user');
        
        // Apply search filter if query exists
        if (!empty($searchQuery)) {
            $searchTerm = '%' . $searchQuery . '%';
            
            // Student Research: search in title, authors, department, program, tags
            $studentQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('authors', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('program', 'LIKE', $searchTerm)
                  ->orWhere('tags', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm);
            });
            
            // Faculty Research: search in title, co_researchers, department, tags
            $facultyQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('co_researchers', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('tags', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm)
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'LIKE', $searchTerm);
                  });
            });
            
            // Thesis: search in title, author, department, program, keywords
            $thesisQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('author', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('program', 'LIKE', $searchTerm)
                  ->orWhere('keywords', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm);
            });
            
            // Dissertation: search in title, author, department, program, keywords
            $dissertationQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('author', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('program', 'LIKE', $searchTerm)
                  ->orWhere('keywords', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm);
            });
        }
        
        // Fetch approved research for display
        // Increased limit for LinkedIn-style feed to show more items
        $limit = !empty($searchQuery) ? 100 : 100;
        
        $approvedStudentResearch = $studentQuery->latest('approved_at')->take($limit)->get();
        $approvedFacultyResearch = $facultyQuery->latest('approved_at')->take($limit)->get();
        $approvedThesis = $thesisQuery->latest('approved_at')->take($limit)->get();
        $approvedDissertations = $dissertationQuery->latest('approved_at')->take($limit)->get();

        // Most recent across all types (by approved_at)
        $mostRecent = collect()
            ->merge($approvedStudentResearch->map(function ($r) { $r->type = 'student'; return $r; }))
            ->merge($approvedFacultyResearch->map(function ($r) { $r->type = 'faculty'; return $r; }))
            ->merge($approvedThesis->map(function ($r) { $r->type = 'thesis'; return $r; }))
            ->merge($approvedDissertations->map(function ($r) { $r->type = 'dissertation'; return $r; }))
            ->sortByDesc('approved_at')
            ->take(100)
            ->values();

        // Attach view counts to mostRecent items
        if ($mostRecent->isNotEmpty()) {
            $itemIdsByType = [];
            foreach ($mostRecent as $item) {
                $itemIdsByType[$item->type][] = $item->id;
            }

            $query = DB::table('research_analytics')
                ->select(
                    'research_type',
                    'research_id',
                    DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"),
                    DB::raw("SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) as downloads")
                );

            $query->where(function($q) use ($itemIdsByType) {
                foreach ($itemIdsByType as $type => $ids) {
                    $q->orWhere(function($sub) use ($type, $ids) {
                        $sub->where('research_type', $type)->whereIn('research_id', $ids);
                    });
                }
            });

            $analyticsData = $query->groupBy('research_type', 'research_id')->get();

            $mostRecent->each(function ($item) use ($analyticsData) {
                $stats = $analyticsData->where('research_type', $item->type)
                                    ->where('research_id', $item->id)
                                    ->first();
                $item->views = $stats ? (int)$stats->views : 0;
                $item->downloads = $stats ? (int)$stats->downloads : 0;
            });
        }

        // Aggregate analytics for most viewed and most popular
        $analytics = DB::table('research_analytics')
            ->select(
                'research_type',
                'research_id',
                DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"),
                DB::raw("SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) as downloads")
            )
            ->groupBy('research_type', 'research_id');

        // When searching, fetch more analytics results
        $analyticsLimit = !empty($searchQuery) ? 50 : 6;

        $mostViewedRaw = (clone $analytics)
            ->orderByDesc('views')
            ->limit($analyticsLimit)
            ->get();

        $mostPopularRaw = (clone $analytics)
            ->select(
                'research_type',
                'research_id',
                DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"),
                DB::raw("SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) as downloads"),
                DB::raw("(SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) * 0.7 + SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) * 1.0) as popularity_score")
            )
            ->orderByDesc('popularity_score')
            ->limit($analyticsLimit)
            ->get();

        $mostViewed = $this->hydrateAnalyticsRows($mostViewedRaw);
        $mostPopular = $this->hydrateAnalyticsRows($mostPopularRaw);
        
        // Apply search filter to mostRecent, mostViewed, and mostPopular if search exists
        if (!empty($searchQuery)) {
            $searchLower = strtolower($searchQuery);
            
            $filterFunction = function($item) use ($searchLower) {
                // Build comprehensive search text
                $searchText = strtolower(
                    ($item->title ?? '') . ' ' .
                    ($item->authors ?? $item->author ?? '') . ' ' .
                    ($item->department ?? '') . ' ' .
                    ($item->program ?? '') . ' ' .
                    ($item->tags ?? $item->keywords ?? '') . ' ' .
                    ($item->co_researchers ?? '') . ' ' .
                    ($item->abstract ?? '') . ' ' .
                    (isset($item->user) && $item->user ? $item->user->name : '')
                );
                return str_contains($searchText, $searchLower);
            };
            
            $mostRecent = $mostRecent->filter($filterFunction)->values();
            $mostViewed = $mostViewed->filter($filterFunction)->values();
            $mostPopular = $mostPopular->filter($filterFunction)->values();
        }
        
        return view('dashboard', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch', 
            'approvedThesis',
            'approvedDissertations',
            'mostRecent',
            'mostViewed',
            'mostPopular',
            'searchQuery'
        ));
    }

    /**
     * Display research organized by department
     */
    public function researchByDepartment()
    {
        // Fetch all approved research for department organization
        $approvedStudentResearch = StudentResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->get();
            
        $approvedFacultyResearch = FacultyResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->get();
            
        $approvedThesis = Thesis::where('status', 'approved')
            ->latest('approved_at')
            ->get();
            
        $approvedDissertations = Dissertation::where('status', 'approved')
            ->latest('approved_at')
            ->get();

        return view('research.by-department', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch', 
            'approvedThesis',
            'approvedDissertations'
        ));
    }

    /**
     * Display the research history for the authenticated user
     */
    public function researchHistory(Request $request)
    {
        $user = Auth::user();
        
        // Get search query
        $searchQuery = $request->get('search', '');
        
        // Get table names from models
        $studentTable = (new StudentResearch)->getTable();
        $facultyTable = (new FacultyResearch)->getTable();
        $thesisTable = (new Thesis)->getTable();
        $dissertationTable = (new Dissertation)->getTable();

        // Initialize collections
        $studentResearch = collect();
        $facultyResearch = collect();
        $theses = collect();
        $dissertations = collect();

        // Check if student research table exists and get data
        if (Schema::hasTable($studentTable)) {
            $studentColumns = ['id', 'title', 'department', 'status', 'created_at', 'user_id', 'authors', 'program', 'tags'];
            if (Schema::hasColumn($studentTable, 'rejection_reason')) {
                $studentColumns[] = 'rejection_reason';
            }
            
            // History page should always show only the user's own research
            $studentQuery = StudentResearch::select($studentColumns)
                ->where('user_id', $user->id);
            
            // Apply search filter
            if (!empty($searchQuery)) {
                $searchTerm = '%' . $searchQuery . '%';
                $studentQuery->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', $searchTerm)
                      ->orWhere('authors', 'LIKE', $searchTerm)
                      ->orWhere('department', 'LIKE', $searchTerm)
                      ->orWhere('program', 'LIKE', $searchTerm)
                      ->orWhere('tags', 'LIKE', $searchTerm);
                });
            }
            
            $studentResearch = $studentQuery->get()
                ->map(function ($item) {
                    $item->type = 'student';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    // Ensure created_at is cast to Carbon
                    if ($item->created_at && !($item->created_at instanceof \Carbon\Carbon)) {
                        $item->created_at = \Carbon\Carbon::parse($item->created_at);
                    }
                    return $item;
                });
        }

        // Check if faculty research table exists and get data
        if (Schema::hasTable($facultyTable)) {
            $facultyColumns = ['id', 'title', 'department', 'status', 'created_at', 'user_id', 'co_researchers', 'tags'];
            if (Schema::hasColumn($facultyTable, 'rejection_reason')) {
                $facultyColumns[] = 'rejection_reason';
            }
            
            // History page should always show only the user's own research
            $facultyQuery = FacultyResearch::select($facultyColumns)
                ->where('user_id', $user->id);
            
            // Apply search filter
            if (!empty($searchQuery)) {
                $searchTerm = '%' . $searchQuery . '%';
                $facultyQuery->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', $searchTerm)
                      ->orWhere('co_researchers', 'LIKE', $searchTerm)
                      ->orWhere('department', 'LIKE', $searchTerm)
                      ->orWhere('tags', 'LIKE', $searchTerm)
                      ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                          $userQuery->where('name', 'LIKE', $searchTerm);
                      });
                });
            }
            
            $facultyResearch = $facultyQuery->get()
                ->map(function ($item) {
                    $item->type = 'faculty';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    // Ensure created_at is cast to Carbon
                    if ($item->created_at && !($item->created_at instanceof \Carbon\Carbon)) {
                        $item->created_at = \Carbon\Carbon::parse($item->created_at);
                    }
                    return $item;
                });
        }

        // Check if thesis table exists and get data
        if (Schema::hasTable($thesisTable)) {
            $thesisColumns = ['id', 'title', 'department', 'status', 'created_at', 'author', 'program', 'keywords'];
            if (Schema::hasColumn($thesisTable, 'rejection_reason')) {
                $thesisColumns[] = 'rejection_reason';
            }
            
            $thesisQuery = Thesis::where('user_id', $user->id)->select($thesisColumns);
            
            // Apply search filter
            if (!empty($searchQuery)) {
                $searchTerm = '%' . $searchQuery . '%';
                $thesisQuery->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', $searchTerm)
                      ->orWhere('author', 'LIKE', $searchTerm)
                      ->orWhere('department', 'LIKE', $searchTerm)
                      ->orWhere('program', 'LIKE', $searchTerm)
                      ->orWhere('keywords', 'LIKE', $searchTerm);
                });
            }
            
            $theses = $thesisQuery->get()
                ->map(function ($item) {
                    $item->type = 'thesis';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    // Ensure created_at is cast to Carbon
                    if ($item->created_at && !($item->created_at instanceof \Carbon\Carbon)) {
                        $item->created_at = \Carbon\Carbon::parse($item->created_at);
                    }
                    return $item;
                });
        }

        // Check if dissertation table exists and get data
        if (Schema::hasTable($dissertationTable)) {
            $dissertationColumns = ['id', 'title', 'department', 'status', 'created_at', 'author', 'program', 'keywords'];
            if (Schema::hasColumn($dissertationTable, 'rejection_reason')) {
                $dissertationColumns[] = 'rejection_reason';
            }
            
            $dissertationQuery = Dissertation::where('user_id', $user->id)->select($dissertationColumns);
            
            // Apply search filter
            if (!empty($searchQuery)) {
                $searchTerm = '%' . $searchQuery . '%';
                $dissertationQuery->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', $searchTerm)
                      ->orWhere('author', 'LIKE', $searchTerm)
                      ->orWhere('department', 'LIKE', $searchTerm)
                      ->orWhere('program', 'LIKE', $searchTerm)
                      ->orWhere('keywords', 'LIKE', $searchTerm);
                });
            }
            
            $dissertations = $dissertationQuery->get()
                ->map(function ($item) {
                    $item->type = 'dissertation';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    // Ensure created_at is cast to Carbon
                    if ($item->created_at && !($item->created_at instanceof \Carbon\Carbon)) {
                        $item->created_at = \Carbon\Carbon::parse($item->created_at);
                    }
                    return $item;
                });
        }

        // Combine all research and sort by created_at descending
        $allResearch = collect()
            ->merge($studentResearch)
            ->merge($facultyResearch)
            ->merge($theses)
            ->merge($dissertations)
            ->sortByDesc('created_at');

        // Calculate status counts
        $pendingCount = $allResearch->where('status', 'pending')->count();
        $approvedCount = $allResearch->where('status', 'approved')->count();
        $rejectedCount = $allResearch->where('status', 'rejected')->count();
        $totalCount = $allResearch->count();

        // Paginate the results
        $currentPage = $request->get('page', 1);
        $perPage = 10;
        $currentItems = $allResearch->forPage($currentPage, $perPage);
        
        $paginatedResearch = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $allResearch->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
                'query' => $request->query(), // Preserve search query in pagination links
            ]
        );

        return view('research.history', [
            'allResearch' => $paginatedResearch,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalCount' => $totalCount,
            'searchQuery' => $searchQuery,
        ]);
    }
    /**
     * Hydrate analytics rows into model items with unified fields for display.
     */
    private function hydrateAnalyticsRows($rows)
    {
        $items = collect();
        foreach ($rows as $row) {
            $model = null;
            switch ($row->research_type) {
                case 'student':
                    $model = StudentResearch::where('status', 'approved')->find($row->research_id);
                    break;
                case 'faculty':
                    $model = FacultyResearch::where('status', 'approved')->find($row->research_id);
                    break;
                case 'thesis':
                    $model = Thesis::where('status', 'approved')->find($row->research_id);
                    break;
                case 'dissertation':
                    $model = Dissertation::where('status', 'approved')->find($row->research_id);
                    break;
            }
            if (!$model) continue;
            $model->type = $row->research_type;
            $model->views = (int) ($row->views ?? 0);
            $model->downloads = (int) ($row->downloads ?? 0);
            $items->push($model);
        }
        return $items;
    }
}
