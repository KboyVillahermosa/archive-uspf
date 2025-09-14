<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        // Redirect admin users to admin dashboard
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Fetch approved research for display
        $approvedStudentResearch = StudentResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();

        $approvedFacultyResearch = FacultyResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();

        $approvedThesis = Thesis::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();

        $approvedDissertations = Dissertation::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();

        // Fetch most viewed and most popular research (top 5)
        $analytics = DB::table('research_analytics')
            ->select(
                'research_type', 'research_id',
                DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"),
                DB::raw("SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) as downloads"),
                DB::raw("(SUM(CASE WHEN action='view' THEN 1 ELSE 0 END)*0.7 + SUM(CASE WHEN action='download' THEN 1 ELSE 0 END)*1.0) as score")
            )
            ->groupBy('research_type', 'research_id');

        $topViewed = (clone $analytics)->orderByDesc('views')->limit(5)->get();
        $topPopular = (clone $analytics)->orderByDesc('score')->limit(5)->get();

        $hydrate = function($rows) {
            $items = [];
            foreach ($rows as $r) {
                $model = null;
                if ($r->research_type === 'student') $model = \App\Models\StudentResearch::find($r->research_id);
                elseif ($r->research_type === 'faculty') $model = \App\Models\FacultyResearch::find($r->research_id);
                elseif ($r->research_type === 'thesis') $model = \App\Models\Thesis::find($r->research_id);
                elseif ($r->research_type === 'dissertation') $model = \App\Models\Dissertation::find($r->research_id);
                if (!$model) continue;
                $items[] = [
                    'model' => $model,
                    'type' => $r->research_type,
                    'views' => (int) ($r->views ?? 0),
                    'downloads' => (int) ($r->downloads ?? 0),
                    'score' => (float) ($r->score ?? 0),
                ];
            }
            return $items;
        };

        $mostViewedResearch = $hydrate($topViewed);
        $mostPopularResearch = $hydrate($topPopular);

        return view('dashboard', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch',
            'approvedThesis',
            'approvedDissertations',
            'mostViewedResearch',
            'mostPopularResearch'
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
            $studentColumns = ['id', 'title', 'department', 'status', 'created_at'];
            if (Schema::hasColumn($studentTable, 'rejection_reason')) {
                $studentColumns[] = 'rejection_reason';
            }
            
            $studentResearch = StudentResearch::where('user_id', $user->id)
                ->select($studentColumns)
                ->get()
                ->map(function ($item) {
                    $item->type = 'student';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    return $item;
                });
        }

        // Check if faculty research table exists and get data
        if (Schema::hasTable($facultyTable)) {
            $facultyColumns = ['id', 'title', 'department', 'status', 'created_at'];
            if (Schema::hasColumn($facultyTable, 'rejection_reason')) {
                $facultyColumns[] = 'rejection_reason';
            }
            
            $facultyResearch = FacultyResearch::where('user_id', $user->id)
                ->select($facultyColumns)
                ->get()
                ->map(function ($item) {
                    $item->type = 'faculty';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    return $item;
                });
        }

        // Check if thesis table exists and get data
        if (Schema::hasTable($thesisTable)) {
            $thesisColumns = ['id', 'title', 'department', 'status', 'created_at'];
            if (Schema::hasColumn($thesisTable, 'rejection_reason')) {
                $thesisColumns[] = 'rejection_reason';
            }
            
            $theses = Thesis::where('user_id', $user->id)
                ->select($thesisColumns)
                ->get()
                ->map(function ($item) {
                    $item->type = 'thesis';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
                    }
                    return $item;
                });
        }

        // Check if dissertation table exists and get data
        if (Schema::hasTable($dissertationTable)) {
            $dissertationColumns = ['id', 'title', 'department', 'status', 'created_at'];
            if (Schema::hasColumn($dissertationTable, 'rejection_reason')) {
                $dissertationColumns[] = 'rejection_reason';
            }
            
            $dissertations = Dissertation::where('user_id', $user->id)
                ->select($dissertationColumns)
                ->get()
                ->map(function ($item) {
                    $item->type = 'dissertation';
                    if (!isset($item->rejection_reason)) {
                        $item->rejection_reason = null;
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
            ]
        );

        return view('research.history', [
            'allResearch' => $paginatedResearch,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalCount' => $totalCount,
        ]);
    }
}
