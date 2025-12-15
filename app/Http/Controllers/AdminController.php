<?php

namespace App\Http\Controllers;

use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Models\User;
use App\Models\Student;
use App\Models\ResearchAnalytic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        
        // Check if user is admin or faculty
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        if (!$isAdmin && !$isFaculty) {
            abort(403, 'Access denied. Admin or Faculty privileges required.');
        }
        
        // Faculty users should see only their department's data
        $userDepartment = $user->department;
        $userCourse = $user->course;
        
        // Base queries with department filtering for faculty
        if ($isFaculty && $userDepartment) {
            $pendingStudentResearch = StudentResearch::where('status', 'pending')
                ->where('department', $userDepartment)
                ->count();
            $pendingFacultyResearch = FacultyResearch::where('status', 'pending')
                ->where('department', $userDepartment)
                ->count();
            $pendingThesis = Thesis::where('status', 'pending')
                ->where('department', $userDepartment)
                ->count();
            $pendingDissertations = Dissertation::where('status', 'pending')
                ->where('department', $userDepartment)
                ->count();
        } else {
            // Admin sees all research
            $pendingStudentResearch = StudentResearch::where('status', 'pending')->count();
            $pendingFacultyResearch = FacultyResearch::where('status', 'pending')->count();
            $pendingThesis = Thesis::where('status', 'pending')->count();
            $pendingDissertations = Dissertation::where('status', 'pending')->count();
        }

        // Count research waiting for adviser approval (for admin reminder)
        $waitingForAdviserApproval = 0;
        if ($isAdmin) {
            $waitingForAdviserApproval = StudentResearch::whereNotNull('adviser_id')
                    ->whereNull('adviser_approved_at')
                    ->where('status', 'pending')
                    ->count()
                + FacultyResearch::whereNotNull('adviser_id')
                    ->whereNull('adviser_approved_at')
                    ->where('status', 'pending')
                    ->count()
                + Thesis::whereNotNull('adviser_id')
                    ->whereNull('adviser_approved_at')
                    ->where('status', 'pending')
                    ->count()
                + Dissertation::whereNotNull('adviser_id')
                    ->whereNull('adviser_approved_at')
                    ->where('status', 'pending')
                    ->count();
        }

        // Line chart month selection via offset
        $offset = (int) $request->query('offset', 0);
        if ($offset < 0) { $offset = 0; }
        $targetMonth = now()->copy()->subMonthsNoOverflow($offset);
        $startOfMonth = $targetMonth->copy()->startOfMonth();
        $endOfMonth = $targetMonth->copy()->endOfMonth();
        $monthName = $targetMonth->format('F Y');

        // Charts data placeholders (filled later if DB facade available)
        $chartDepartments = [];
        $chartDepartmentCounts = [];
        $chartPrograms = [];
        $chartProgramCounts = [];
        $chartTopViewed = [];
        $chartTopDownloaded = [];
        $chartTopPopular = [];
        $chartData = [];

        if (class_exists(\Illuminate\Support\Facades\DB::class)) {
            $deptCounts = collect();
            
            // Apply department filtering for faculty users
            if ($isFaculty && $userDepartment) {
                $deptCounts = $deptCounts
                    ->merge(StudentResearch::where('status','approved')->where('department', $userDepartment)->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(FacultyResearch::where('status','approved')->where('department', $userDepartment)->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Thesis::where('status','approved')->where('department', $userDepartment)->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Dissertation::where('status','approved')->where('department', $userDepartment)->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'));
            } else {
                // Admin sees all departments
                $deptCounts = $deptCounts
                    ->merge(StudentResearch::where('status','approved')->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(FacultyResearch::where('status','approved')->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Thesis::where('status','approved')->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Dissertation::where('status','approved')->select('department', DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'));
            }

            $departmentToCount = [];
            foreach ($deptCounts as $dept => $count) {
                if (!$dept) continue;
                $departmentToCount[$dept] = ($departmentToCount[$dept] ?? 0) + (int) $count;
            }
            arsort($departmentToCount);
            $chartDepartments = array_slice(array_keys($departmentToCount), 0, 8);
            $chartDepartmentCounts = array_map(fn($k) => $departmentToCount[$k], $chartDepartments);

            // Filter programs by department for faculty
            if ($isFaculty && $userDepartment) {
                $programCounts = StudentResearch::where('status','approved')
                    ->where('department', $userDepartment)
                    ->select('program', DB::raw('count(*) as total'))
                    ->groupBy('program')
                    ->orderByDesc('total')
                    ->limit(8)
                    ->get();
            } else {
                $programCounts = StudentResearch::where('status','approved')
                    ->select('program', DB::raw('count(*) as total'))
                    ->groupBy('program')
                    ->orderByDesc('total')
                    ->limit(8)
                    ->get();
            }
            $chartPrograms = $programCounts->pluck('program')->map(fn($v)=>$v ?: 'Unknown')->toArray();
            $chartProgramCounts = $programCounts->pluck('total')->toArray();

            $analytics = \DB::table('research_analytics')
                ->select(
                    'research_type', 'research_id',
                    \DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"),
                    \DB::raw("SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) as downloads")
                )
                ->groupBy('research_type','research_id');

            $topViewed = (clone $analytics)->orderByDesc('views')->limit(5)->get();
            $topDownloaded = (clone $analytics)->orderByDesc('downloads')->limit(5)->get();
            $topPopular = (clone $analytics)
                ->select('research_type','research_id',
                    \DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"),
                    \DB::raw("SUM(CASE WHEN action='download' THEN 1 ELSE 0 END) as downloads"),
                    \DB::raw("(SUM(CASE WHEN action='view' THEN 1 ELSE 0 END)*0.7 + SUM(CASE WHEN action='download' THEN 1 ELSE 0 END)*1.0) as score")
                )
                ->orderByDesc('score')->limit(5)->get();

            $hydrate = function($rows) use ($isFaculty, $userDepartment, $userCourse) {
                $items = [];
                foreach ($rows as $r) {
                    $model = null; $title = null;
                    if ($r->research_type === 'student') $model = StudentResearch::find($r->research_id);
                    elseif ($r->research_type === 'faculty') $model = FacultyResearch::find($r->research_id);
                    elseif ($r->research_type === 'thesis') $model = Thesis::find($r->research_id);
                    elseif ($r->research_type === 'dissertation') $model = Dissertation::find($r->research_id);
                    if (!$model) continue;

                    // If faculty user, only include items that belong to their department (and course/program for student research)
                    if ($isFaculty && $userDepartment) {
                        if ($r->research_type === 'student') {
                            if ($model->department !== $userDepartment) continue;
                            if ($userCourse && $model->program && stripos($model->program, $userCourse) === false) continue;
                        } else {
                            if (isset($model->department) && $model->department !== $userDepartment) continue;
                        }
                    }

                    $title = $model->title;
                    $items[] = [
                        'label' => mb_strimwidth($title, 0, 32, '…'),
                        'views' => (int) ($r->views ?? 0),
                        'downloads' => (int) ($r->downloads ?? 0),
                    ];
                }
                return $items;
            };

            $chartTopViewed = $hydrate($topViewed);
            $chartTopDownloaded = $hydrate($topDownloaded);
            $chartTopPopular = $hydrate($topPopular);

            // Build daily views for selected month by research type
            // We'll query per research type and, for faculty users, join the corresponding research table to filter by department/course
            $days = [];
            $cursor = $startOfMonth->copy();
            while ($cursor->lte($endOfMonth)) {
                $days[$cursor->toDateString()] = [
                    'day' => $cursor->format('M d'),
                    'student' => 0,
                    'faculty' => 0,
                    'thesis' => 0,
                    'dissertation' => 0,
                ];
                $cursor->addDay();
            }

            $types = ['student' => new StudentResearch(), 'faculty' => new FacultyResearch(), 'thesis' => new Thesis(), 'dissertation' => new Dissertation()];

            foreach (array_keys($types) as $type) {
                $query = \DB::table('research_analytics')
                    ->select(\DB::raw('DATE(research_analytics.created_at) as day'), \DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views"))
                    ->where('research_type', $type)
                    ->whereBetween('research_analytics.created_at', [$startOfMonth, $endOfMonth]);

                if ($isFaculty && $userDepartment) {
                    $modelInstance = $types[$type];
                    $table = $modelInstance->getTable();
                    $query->join($table, 'research_analytics.research_id', '=', "{$table}.id")
                        ->where("{$table}.department", $userDepartment);

                    // For student research also filter by program/course
                    if ($type === 'student' && $userCourse) {
                        $query->where("{$table}.program", 'like', "%{$userCourse}%");
                    }
                }

                $rows = $query->groupBy(\DB::raw('DATE(research_analytics.created_at)'))->orderBy('day')->get();
                foreach ($rows as $row) {
                    $key = (string) $row->day;
                    if (!isset($days[$key])) continue;
                    $days[$key][$type] = (int) $row->views;
                }
            }

            $chartData = array_values($days);
        }

        // Fetch student activity data (only for admins)
        $studentActivity = [
            'summary' => [],
            'recent_views' => [],
            'recent_downloads' => [],
        ];
        if ($isAdmin) {
            // Get recent views by students (users with role 'student' or users with student relationship)
            $recentViews = ResearchAnalytic::where('action', 'view')
                ->whereNotNull('user_id')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            // Get recent downloads by students
            $recentDownloads = ResearchAnalytic::where('action', 'download')
                ->whereNotNull('user_id')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            // Hydrate views with research details and user info
            $studentViews = [];
            foreach ($recentViews as $view) {
                $user = $view->user;
                if (!$user) continue;

                // Only show students (users with role 'student' or users with department/course)
                $isStudent = $user->hasRole('student') || $user->role === 'student' || ($user->department && $user->course);
                if (!$isStudent) continue;

                $research = null;
                $researchTitle = 'Unknown Research';

                if ($view->research_type === 'student') {
                    $research = StudentResearch::find($view->research_id);
                } elseif ($view->research_type === 'faculty') {
                    $research = FacultyResearch::find($view->research_id);
                } elseif ($view->research_type === 'thesis') {
                    $research = Thesis::find($view->research_id);
                } elseif ($view->research_type === 'dissertation') {
                    $research = Dissertation::find($view->research_id);
                }

                if ($research) {
                    $researchTitle = $research->title;
                }

                $studentViews[] = [
                    'user_id' => $user->id,
                    'user_name' => $user->name ?? ($user->first_name . ' ' . $user->last_name),
                    'user_email' => $user->email,
                    'department' => $user->department,
                    'program' => $user->course,
                    'research_type' => $view->research_type,
                    'research_id' => $view->research_id,
                    'research_title' => $researchTitle,
                    'viewed_at' => $view->created_at,
                ];
            }

            // Hydrate downloads with research details and user info
            $studentDownloads = [];
            foreach ($recentDownloads as $download) {
                $user = $download->user;
                if (!$user) continue;

                // Only show students
                $isStudent = $user->hasRole('student') || $user->role === 'student' || ($user->department && $user->course);
                if (!$isStudent) continue;

                $research = null;
                $researchTitle = 'Unknown Research';

                if ($download->research_type === 'student') {
                    $research = StudentResearch::find($download->research_id);
                } elseif ($download->research_type === 'faculty') {
                    $research = FacultyResearch::find($download->research_id);
                } elseif ($download->research_type === 'thesis') {
                    $research = Thesis::find($download->research_id);
                } elseif ($download->research_type === 'dissertation') {
                    $research = Dissertation::find($download->research_id);
                }

                if ($research) {
                    $researchTitle = $research->title;
                }

                $studentDownloads[] = [
                    'user_id' => $user->id,
                    'user_name' => $user->name ?? ($user->first_name . ' ' . $user->last_name),
                    'user_email' => $user->email,
                    'department' => $user->department,
                    'program' => $user->course,
                    'research_type' => $download->research_type,
                    'research_id' => $download->research_id,
                    'research_title' => $researchTitle,
                    'download_purpose' => $download->download_purpose,
                    'download_notes' => $download->download_notes,
                    'downloaded_at' => $download->created_at,
                ];
            }

            // Group by user to show summary
            $studentActivitySummary = [];
            foreach ($studentViews as $view) {
                $userId = $view['user_id'];
                if (!isset($studentActivitySummary[$userId])) {
                    $studentActivitySummary[$userId] = [
                        'user_id' => $userId,
                        'user_name' => $view['user_name'],
                        'user_email' => $view['user_email'],
                        'department' => $view['department'],
                        'program' => $view['program'],
                        'views_count' => 0,
                        'downloads_count' => 0,
                        'recent_views' => [],
                        'recent_downloads' => [],
                    ];
                }
                $studentActivitySummary[$userId]['views_count']++;
                if (count($studentActivitySummary[$userId]['recent_views']) < 5) {
                    $studentActivitySummary[$userId]['recent_views'][] = $view;
                }
            }

            foreach ($studentDownloads as $download) {
                $userId = $download['user_id'];
                if (!isset($studentActivitySummary[$userId])) {
                    $studentActivitySummary[$userId] = [
                        'user_id' => $userId,
                        'user_name' => $download['user_name'],
                        'user_email' => $download['user_email'],
                        'department' => $download['department'],
                        'program' => $download['program'],
                        'views_count' => 0,
                        'downloads_count' => 0,
                        'recent_views' => [],
                        'recent_downloads' => [],
                    ];
                }
                $studentActivitySummary[$userId]['downloads_count']++;
                if (count($studentActivitySummary[$userId]['recent_downloads']) < 5) {
                    $studentActivitySummary[$userId]['recent_downloads'][] = $download;
                }
            }

            // Sort by total activity (views + downloads)
            usort($studentActivitySummary, function($a, $b) {
                $totalA = $a['views_count'] + $a['downloads_count'];
                $totalB = $b['views_count'] + $b['downloads_count'];
                return $totalB - $totalA;
            });

            $studentActivity = [
                'summary' => array_slice($studentActivitySummary, 0, 20), // Top 20 most active students
                'recent_views' => array_slice($studentViews, 0, 20),
                'recent_downloads' => array_slice($studentDownloads, 0, 20),
            ];
        }

        return view('admin.dashboard', compact(
            'pendingStudentResearch',
            'pendingFacultyResearch',
            'pendingThesis',
            'pendingDissertations',
            'waitingForAdviserApproval',
            'monthName',
            'offset',
            'chartData',
            'chartDepartments',
            'chartDepartmentCounts',
            'chartPrograms',
            'chartProgramCounts',
            'chartTopViewed',
            'chartTopDownloaded',
            'chartTopPopular',
            'studentActivity',
            'isAdmin'
        ));
    }

    public function allResearch(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        if (!$isAdmin && !$isFaculty) {
            abort(403, 'Access denied. Admin or Faculty privileges required.');
        }
        
        $userDepartment = $user->department;
        $userCourse = $user->course;
        
        // Get filter parameters
        $statusFilter = $request->get('status', 'all'); // all, pending, approved, rejected
        $typeFilter = $request->get('type', 'all'); // all, student, faculty, thesis, dissertation
        
        // Build queries based on filters
        $studentQuery = StudentResearch::query();
        $facultyQuery = FacultyResearch::query();
        $thesisQuery = Thesis::query();
        $dissertationQuery = Dissertation::query();
        
        // Apply department filter for faculty
        if ($isFaculty && $userDepartment) {
            $studentQuery->where('department', $userDepartment);
            $facultyQuery->where('department', $userDepartment);
            $thesisQuery->where('department', $userDepartment);
            $dissertationQuery->where('department', $userDepartment);
            
            if ($userCourse) {
                $studentQuery->where('program', 'like', "%{$userCourse}%");
            }
        }
        
        // Apply status filter
        if ($statusFilter !== 'all') {
            $studentQuery->where('status', $statusFilter);
            $facultyQuery->where('status', $statusFilter);
            $thesisQuery->where('status', $statusFilter);
            $dissertationQuery->where('status', $statusFilter);
        }
        
        // Get research based on type filter
        $studentResearch = collect();
        $facultyResearch = collect();
        $thesis = collect();
        $dissertations = collect();
        
        if ($typeFilter === 'all' || $typeFilter === 'student') {
            $studentResearch = $studentQuery->with('user')->latest('created_at')->get();
        }
        if ($typeFilter === 'all' || $typeFilter === 'faculty') {
            $facultyResearch = $facultyQuery->with('user')->latest('created_at')->get();
        }
        if ($typeFilter === 'all' || $typeFilter === 'thesis') {
            $thesis = $thesisQuery->with('user')->latest('created_at')->get();
        }
        if ($typeFilter === 'all' || $typeFilter === 'dissertation') {
            $dissertations = $dissertationQuery->with('user')->latest('created_at')->get();
        }
        
        // Combine all research for display
        $allResearch = collect()
            ->merge($studentResearch->map(fn($r) => (object)['type' => 'student', 'data' => $r]))
            ->merge($facultyResearch->map(fn($r) => (object)['type' => 'faculty', 'data' => $r]))
            ->merge($thesis->map(fn($r) => (object)['type' => 'thesis', 'data' => $r]))
            ->merge($dissertations->map(fn($r) => (object)['type' => 'dissertation', 'data' => $r]))
            ->sortByDesc(fn($item) => $item->data->created_at);
        
        // Get counts for stats
        $totalCount = $allResearch->count();
        $pendingCount = $allResearch->where('data.status', 'pending')->count();
        $approvedCount = $allResearch->where('data.status', 'approved')->count();
        $rejectedCount = $allResearch->where('data.status', 'rejected')->count();
        
        return view('admin.all-research', compact(
            'allResearch',
            'statusFilter',
            'typeFilter',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'isFaculty',
            'userDepartment'
        ));
    }

    public function filterForm(Request $request)
    {
        $statusFilter = $request->get('status', 'all');
        $typeFilter = $request->get('type', 'all');
        
        return view('admin.partials.filter-form', compact('statusFilter', 'typeFilter'));
    }

    public function pendingResearch()
    {
        $user = auth()->user();
        // Check if user has any approve permission or is admin
        $canApprove = $user->hasRole('admin') 
            || $user->hasPermissionTo('approve student-research')
            || $user->hasPermissionTo('approve faculty-research')
            || $user->hasPermissionTo('approve thesis')
            || $user->hasPermissionTo('approve dissertations');
        
        if (!$canApprove) {
            abort(403, 'Access denied. You do not have permission to view pending research.');
        }
        // Determine faculty and their department/course
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        $userDepartment = $user->department;
        $userCourse = $user->course;

        if ($isFaculty && $userDepartment) {
            // For faculty, show only pending research for their department (and course/program for student research)
            $studentQuery = StudentResearch::where('status', 'pending')->where('department', $userDepartment);
            if ($userCourse) {
                $studentQuery->where('program', 'like', "%{$userCourse}%");
            }
            $studentResearch = $studentQuery->with('user')->latest()->get();

            $facultyResearch = FacultyResearch::where('status', 'pending')
                ->where('department', $userDepartment)
                ->with('user')
                ->latest()
                ->get();

            $thesis = Thesis::where('status', 'pending')
                ->where('department', $userDepartment)
                ->with('user')
                ->latest()
                ->get();

            $dissertations = Dissertation::where('status', 'pending')
                ->where('department', $userDepartment)
                ->with('user')
                ->latest()
                ->get();
        } else {
            // Admins see all pending research
            $studentResearch = StudentResearch::where('status', 'pending')->with('user')->latest()->get();
            $facultyResearch = FacultyResearch::where('status', 'pending')->with('user')->latest()->get();
            $thesis = Thesis::where('status', 'pending')->with('user')->latest()->get();
            $dissertations = Dissertation::where('status', 'pending')->with('user')->latest()->get();
        }

        return view('admin.pending-research', compact(
            'studentResearch',
            'facultyResearch',
            'thesis',
            'dissertations'
        ));
    }

    // Modal form methods
    public function approveStudentForm($id)
    {
        $research = StudentResearch::findOrFail($id);
        return view('admin.partials.approve-form', [
            'research' => $research,
            'type' => 'student',
            'approveRoute' => route('admin.approve.student', $id),
            'rejectRoute' => route('admin.reject.student.form', $id)
        ]);
    }

    public function rejectStudentForm($id)
    {
        $research = StudentResearch::findOrFail($id);
        return view('admin.partials.reject-form', [
            'research' => $research,
            'type' => 'student',
            'rejectRoute' => route('admin.reject.student', $id)
        ]);
    }

    public function approveFacultyForm($id)
    {
        $research = FacultyResearch::findOrFail($id);
        return view('admin.partials.approve-form', [
            'research' => $research,
            'type' => 'faculty',
            'approveRoute' => route('admin.approve.faculty', $id),
            'rejectRoute' => route('admin.reject.faculty.form', $id)
        ]);
    }

    public function rejectFacultyForm($id)
    {
        $research = FacultyResearch::findOrFail($id);
        return view('admin.partials.reject-form', [
            'research' => $research,
            'type' => 'faculty',
            'rejectRoute' => route('admin.reject.faculty', $id)
        ]);
    }

    public function approveThesisForm($id)
    {
        $research = Thesis::findOrFail($id);
        return view('admin.partials.approve-form', [
            'research' => $research,
            'type' => 'thesis',
            'approveRoute' => route('admin.approve.thesis', $id),
            'rejectRoute' => route('admin.reject.thesis.form', $id)
        ]);
    }

    public function rejectThesisForm($id)
    {
        $research = Thesis::findOrFail($id);
        return view('admin.partials.reject-form', [
            'research' => $research,
            'type' => 'thesis',
            'rejectRoute' => route('admin.reject.thesis', $id)
        ]);
    }

    public function approveDissertationForm($id)
    {
        $research = Dissertation::findOrFail($id);
        return view('admin.partials.approve-form', [
            'research' => $research,
            'type' => 'dissertation',
            'approveRoute' => route('admin.approve.dissertation', $id),
            'rejectRoute' => route('admin.reject.dissertation.form', $id)
        ]);
    }

    public function rejectDissertationForm($id)
    {
        $research = Dissertation::findOrFail($id);
        return view('admin.partials.reject-form', [
            'research' => $research,
            'type' => 'dissertation',
            'rejectRoute' => route('admin.reject.dissertation', $id)
        ]);
    }

    public function approveStudentResearch(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('approve student-research')) {
            abort(403, 'Access denied. You do not have permission to approve student research.');
        }
        
        $research = StudentResearch::findOrFail($id);
        
        // Faculty can only approve research from their department (and course/program for student research)
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        $userCourse = $user->course;
        if ($isFaculty && $user->department && $research->department !== $user->department) {
            abort(403, 'Access denied. You can only approve research from your department.');
        }
        if ($isFaculty && $userCourse && isset($research->program) && $research->program && stripos($research->program, $userCourse) === false) {
            abort(403, 'Access denied. You can only approve research for your assigned course/program.');
        }
        
        $updateData = [
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ];

        // If admin approves research with assigned adviser that hasn't been approved by adviser yet, mark it as approved
        $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        if ($isAdmin && $research->adviser_id && !$research->adviser_approved_at) {
            $updateData['adviser_approved_at'] = now();
            $updateData['adviser_approved_by'] = auth()->id();
        }

        $research->update($updateData);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Student research approved successfully!']);
        }
        return redirect()->back()->with('success', 'Student research approved successfully!');
    }

    public function rejectStudentResearch(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('reject student-research')) {
            abort(403, 'Access denied. You do not have permission to reject student research.');
        }
        
        $research = StudentResearch::findOrFail($id);
        
        // Faculty can only reject research from their department (and course/program for student research)
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        $userCourse = $user->course;
        if ($isFaculty && $user->department && $research->department !== $user->department) {
            abort(403, 'Access denied. You can only reject research from your department.');
        }
        if ($isFaculty && $userCourse && isset($research->program) && $research->program && stripos($research->program, $userCourse) === false) {
            abort(403, 'Access denied. You can only reject research for your assigned course/program.');
        }
        
        $research->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Student research rejected.']);
        }
        return redirect()->back()->with('success', 'Student research rejected.');
    }

    public function approveFacultyResearch(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('approve faculty-research')) {
            abort(403, 'Access denied. You do not have permission to approve faculty research.');
        }
        
        $research = FacultyResearch::findOrFail($id);
        
        // Faculty can only approve research from their department
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        if ($isFaculty && $user->department && $research->department !== $user->department) {
            abort(403, 'Access denied. You can only approve research from your department.');
        }
        
        $updateData = [
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ];

        // If admin approves research with assigned adviser that hasn't been approved by adviser yet, mark it as approved
        $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        if ($isAdmin && $research->adviser_id && !$research->adviser_approved_at) {
            $updateData['adviser_approved_at'] = now();
            $updateData['adviser_approved_by'] = auth()->id();
        }

        $research->update($updateData);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Faculty research approved successfully!']);
        }
        return redirect()->back()->with('success', 'Faculty research approved successfully!');
    }

    public function rejectFacultyResearch(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('reject faculty-research')) {
            abort(403, 'Access denied. You do not have permission to reject faculty research.');
        }
        
        $research = FacultyResearch::findOrFail($id);
        
        // Faculty can only reject research from their department
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        if ($isFaculty && $user->department && $research->department !== $user->department) {
            abort(403, 'Access denied. You can only reject research from your department.');
        }
        
        $research->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Faculty research rejected.']);
        }
        return redirect()->back()->with('success', 'Faculty research rejected.');
    }

    public function approveThesis(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('approve thesis')) {
            abort(403, 'Access denied. You do not have permission to approve thesis.');
        }
        
        $thesis = Thesis::findOrFail($id);
        
        // Faculty can only approve thesis from their department
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        if ($isFaculty && $user->department && $thesis->department !== $user->department) {
            abort(403, 'Access denied. You can only approve thesis from your department.');
        }
        
        $updateData = [
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ];

        // If admin approves research with assigned adviser that hasn't been approved by adviser yet, mark it as approved
        $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        if ($isAdmin && $thesis->adviser_id && !$thesis->adviser_approved_at) {
            $updateData['adviser_approved_at'] = now();
            $updateData['adviser_approved_by'] = auth()->id();
        }

        $thesis->update($updateData);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Thesis approved successfully!']);
        }
        return redirect()->back()->with('success', 'Thesis approved successfully!');
    }

    public function rejectThesis(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('reject thesis')) {
            abort(403, 'Access denied. You do not have permission to reject thesis.');
        }
        
        $thesis = Thesis::findOrFail($id);
        
        // Faculty can only reject thesis from their department
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        if ($isFaculty && $user->department && $thesis->department !== $user->department) {
            abort(403, 'Access denied. You can only reject thesis from your department.');
        }
        
        $thesis->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Thesis rejected.']);
        }
        return redirect()->back()->with('success', 'Thesis rejected.');
    }

    public function approveDissertation(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('approve dissertations')) {
            abort(403, 'Access denied. You do not have permission to approve dissertations.');
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        // Faculty can only approve dissertations from their department
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        if ($isFaculty && $user->department && $dissertation->department !== $user->department) {
            abort(403, 'Access denied. You can only approve dissertations from your department.');
        }
        
        $updateData = [
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ];

        // If admin approves research with assigned adviser that hasn't been approved by adviser yet, mark it as approved
        $isAdmin = $user->hasRole('admin') || $user->role === 'admin';
        if ($isAdmin && $dissertation->adviser_id && !$dissertation->adviser_approved_at) {
            $updateData['adviser_approved_at'] = now();
            $updateData['adviser_approved_by'] = auth()->id();
        }

        $dissertation->update($updateData);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Dissertation approved successfully!']);
        }
        return redirect()->back()->with('success', 'Dissertation approved successfully!');
    }

    public function rejectDissertation(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('admin') && !$user->hasPermissionTo('reject dissertations')) {
            abort(403, 'Access denied. You do not have permission to reject dissertations.');
        }
        
        $dissertation = Dissertation::findOrFail($id);
        
        // Faculty can only reject dissertations from their department
        $isFaculty = $user->role === 'faculty' || $user->hasRole('faculty');
        if ($isFaculty && $user->department && $dissertation->department !== $user->department) {
            abort(403, 'Access denied. You can only reject dissertations from your department.');
        }
        
        $dissertation->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Dissertation rejected.']);
        }
        return redirect()->back()->with('success', 'Dissertation rejected.');
    }

    /**
     * Delete research
     */
    public function deleteResearch(Request $request, $type, $id)
    {
        $user = auth()->user();
        $research = null;
        $canDelete = false;

        switch ($type) {
            case 'student':
                $research = StudentResearch::findOrFail($id);
                $canDelete = $user->hasRole('admin') 
                    || $user->hasPermissionTo('delete student-research') 
                    || $research->user_id === $user->id;
                break;
            case 'faculty':
                $research = FacultyResearch::findOrFail($id);
                $canDelete = $user->hasRole('admin') 
                    || $user->hasPermissionTo('delete faculty-research') 
                    || $research->user_id === $user->id;
                break;
            case 'thesis':
                $research = Thesis::findOrFail($id);
                $canDelete = $user->hasRole('admin') || $research->user_id === $user->id;
                break;
            case 'dissertation':
                $research = Dissertation::findOrFail($id);
                $canDelete = $user->hasRole('admin') || $research->user_id === $user->id;
                break;
            default:
                abort(404, 'Invalid research type');
        }

        if (!$canDelete) {
            abort(403, 'You do not have permission to delete this research.');
        }

        // Delete associated files if they exist
        if (isset($research->research_file) && $research->research_file) {
            $filePath = storage_path('app/public/' . $research->research_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if (isset($research->banner_image) && $research->banner_image) {
            $bannerPath = storage_path('app/public/' . $research->banner_image);
            if (file_exists($bannerPath)) {
                unlink($bannerPath);
            }
        }

        // Delete the research record
        $research->delete();

        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Research deleted successfully!']);
        }

        return redirect()->back()->with('success', 'Research deleted successfully!');
    }

    /**
     * Display a listing of users.
     */
    public function users(Request $request)
    {
        // #region agent log
        file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'AdminController.php:938', 'message' => 'users() method entry', 'data' => ['user_id' => auth()->id(), 'is_authenticated' => auth()->check()], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
        // #endregion
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        // #region agent log
        file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'AdminController.php:942', 'message' => 'Before permission check', 'data' => ['isAdmin' => $isAdmin, 'isFaculty' => $isFaculty, 'user_role' => $user->role], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
        // #endregion
        
        // Check authorization - allow admin or faculty with department permissions
        try {
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'AdminController.php:947', 'message' => 'Checking permission: manage department users', 'data' => ['will_check' => !$isAdmin && $isFaculty], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
            // #endregion
            if (!$isAdmin && !($isFaculty && $user->hasPermissionTo('manage department users'))) {
                $this->authorize('viewAny', User::class);
            }
        } catch (\Exception $e) {
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['sessionId' => 'debug-session', 'runId' => 'run1', 'hypothesisId' => 'A', 'location' => 'AdminController.php:952', 'message' => 'Permission check exception', 'data' => ['exception' => get_class($e), 'message' => $e->getMessage()], 'timestamp' => time() * 1000]) . "\n", FILE_APPEND);
            // #endregion
            throw $e;
        }
        
        // Filter users based on role
        if ($isFaculty && !$isAdmin && $user->department) {
            // Faculty can only see users from their department
            $users = User::with('roles')
                ->where('department', $user->department)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            // Admin can see all users
            $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(15);
        }
        
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        // Check authorization - allow admin or faculty with department permissions
        if (!$isAdmin && !($isFaculty && $user->hasPermissionTo('manage department users'))) {
            $this->authorize('create', User::class);
        }
        
        $roles = Role::all();
        
        // If AJAX request (modal), return just the form
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('admin.users.form', compact('roles'));
        }
        
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        // Check authorization - allow admin or faculty with department permissions
        if (!$isAdmin && !($isFaculty && $user->hasPermissionTo('manage department users'))) {
            $this->authorize('create', User::class);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|exists:roles,name',
            'status' => 'nullable|in:active,inactive',
            'department' => 'nullable|string|max:255',
            'course' => 'nullable|string|max:255',
        ], [
            'role.exists' => 'The selected role does not exist.',
        ]);

        // For faculty users, auto-assign their department and course
        $department = $request->department;
        $course = $request->course;
        
        if ($isFaculty && !$isAdmin) {
            $department = $user->department;
            $course = $user->course;
        }

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 'active',
            'role' => $request->role ?? 'student',
            'department' => $department,
            'course' => $course,
        ]);

        // Assign Spatie role
        if ($request->filled('role') && $request->role !== '') {
            $newUser->assignRole($request->role);
        }
        
        // Refresh user to reload relationships
        $newUser->refresh();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success', 
                'message' => 'User created successfully!',
                'user' => $newUser->load('roles')
            ]);
        }
        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user->load('roles', 'student');
        
        // Get user's research submissions
        $studentResearch = StudentResearch::where('user_id', $user->id)->get();
        $facultyResearch = FacultyResearch::where('user_id', $user->id)->get();
        $theses = Thesis::where('user_id', $user->id)->get();
        $dissertations = Dissertation::where('user_id', $user->id)->get();
        
        // Calculate totals
        $totalSubmissions = $studentResearch->count() + $facultyResearch->count() + $theses->count() + $dissertations->count();
        $approvedSubmissions = $studentResearch->where('status', 'approved')->count() 
                            + $facultyResearch->where('status', 'approved')->count()
                            + $theses->where('status', 'approved')->count()
                            + $dissertations->where('status', 'approved')->count();
        $pendingSubmissions = $studentResearch->where('status', 'pending')->count() 
                           + $facultyResearch->where('status', 'pending')->count()
                           + $theses->where('status', 'pending')->count()
                           + $dissertations->where('status', 'pending')->count();
        $rejectedSubmissions = $studentResearch->where('status', 'rejected')->count() 
                            + $facultyResearch->where('status', 'rejected')->count()
                            + $theses->where('status', 'rejected')->count()
                            + $dissertations->where('status', 'rejected')->count();
        
        // Calculate total views and downloads for user's research
        $totalViews = 0;
        $totalDownloads = 0;
        
        foreach ($studentResearch as $research) {
            $totalViews += ResearchAnalytic::getViewCount('student', $research->id);
            $totalDownloads += ResearchAnalytic::getDownloadCount('student', $research->id);
        }
        foreach ($facultyResearch as $research) {
            $totalViews += ResearchAnalytic::getViewCount('faculty', $research->id);
            $totalDownloads += ResearchAnalytic::getDownloadCount('faculty', $research->id);
        }
        foreach ($theses as $thesis) {
            $totalViews += ResearchAnalytic::getViewCount('thesis', $thesis->id);
            $totalDownloads += ResearchAnalytic::getDownloadCount('thesis', $thesis->id);
        }
        foreach ($dissertations as $dissertation) {
            $totalViews += ResearchAnalytic::getViewCount('dissertation', $dissertation->id);
            $totalDownloads += ResearchAnalytic::getDownloadCount('dissertation', $dissertation->id);
        }
        
        // Get user's activity (what research they viewed and downloaded)
        $userViews = ResearchAnalytic::where('user_id', $user->id)
            ->where('action', 'view')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $userDownloads = ResearchAnalytic::where('user_id', $user->id)
            ->where('action', 'download')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get unique counts
        $uniqueViewsCount = $userViews->unique(function($item) {
            return $item->research_type . '-' . $item->research_id;
        })->count();
        
        $uniqueDownloadsCount = $userDownloads->unique(function($item) {
            return $item->research_type . '-' . $item->research_id;
        })->count();
        
        // Limit to 20 most recent for display (increased from 10)
        $userViews = $userViews->take(20);
        $userDownloads = $userDownloads->take(20);
        
        // Get research details for views
        $viewedResearch = collect();
        foreach ($userViews as $view) {
            $research = null;
            switch ($view->research_type) {
                case 'student':
                    $research = StudentResearch::find($view->research_id);
                    break;
                case 'faculty':
                    $research = FacultyResearch::find($view->research_id);
                    break;
                case 'thesis':
                    $research = Thesis::find($view->research_id);
                    break;
                case 'dissertation':
                    $research = Dissertation::find($view->research_id);
                    break;
            }
            if ($research) {
                $viewedResearch->push([
                    'type' => ucfirst($view->research_type) . ' Research',
                    'title' => $research->title ?? 'N/A',
                    'viewed_at' => $view->created_at,
                    'research_id' => $view->research_id,
                    'research_type' => $view->research_type
                ]);
            }
        }
        
        // Get research details for downloads
        $downloadedResearch = collect();
        foreach ($userDownloads as $download) {
            $research = null;
            switch ($download->research_type) {
                case 'student':
                    $research = StudentResearch::find($download->research_id);
                    break;
                case 'faculty':
                    $research = FacultyResearch::find($download->research_id);
                    break;
                case 'thesis':
                    $research = Thesis::find($download->research_id);
                    break;
                case 'dissertation':
                    $research = Dissertation::find($download->research_id);
                    break;
            }
            if ($research) {
                $downloadedResearch->push([
                    'type' => ucfirst($download->research_type) . ' Research',
                    'title' => $research->title ?? 'N/A',
                    'downloaded_at' => $download->created_at,
                    'purpose' => $download->download_purpose,
                    'notes' => $download->download_notes,
                    'research_id' => $download->research_id,
                    'research_type' => $download->research_type
                ]);
            }
        }
        
        // Get recent submissions (last 5)
        $recentSubmissions = collect()
            ->merge($studentResearch->take(5)->map(function($r) {
                return ['type' => 'Student Research', 'title' => $r->title, 'status' => $r->status, 'created_at' => $r->created_at];
            }))
            ->merge($facultyResearch->take(5)->map(function($r) {
                return ['type' => 'Faculty Research', 'title' => $r->title, 'status' => $r->status, 'created_at' => $r->created_at];
            }))
            ->merge($theses->take(5)->map(function($r) {
                return ['type' => 'Thesis', 'title' => $r->title, 'status' => $r->status, 'created_at' => $r->created_at];
            }))
            ->merge($dissertations->take(5)->map(function($r) {
                return ['type' => 'Dissertation', 'title' => $r->title, 'status' => $r->status, 'created_at' => $r->created_at];
            }))
            ->sortByDesc('created_at')
            ->take(5);
        
        return view('admin.users.show', compact(
            'user', 
            'totalSubmissions', 
            'approvedSubmissions', 
            'pendingSubmissions', 
            'rejectedSubmissions',
            'totalViews',
            'totalDownloads',
            'recentSubmissions',
            'studentResearch',
            'facultyResearch',
            'theses',
            'dissertations',
            'userViews',
            'userDownloads',
            'viewedResearch',
            'downloadedResearch',
            'uniqueViewsCount',
            'uniqueDownloadsCount'
        ));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        // Handle password change separately
        if ($request->has('type') && $request->type === 'password') {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success', 
                    'message' => 'Password updated successfully!'
                ]);
            }
            return redirect()->route('admin.users.show', $user)->with('success', 'Password updated successfully!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'nullable|string|exists:roles,name',
            'status' => 'nullable|in:active,inactive',
        ], [
            'role.exists' => 'The selected role does not exist.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status ?? $user->status,
            'role' => $request->role ?? $user->role,
        ]);

        // Sync Spatie role
        if ($request->filled('role') && $request->role !== '') {
            $user->syncRoles([$request->role]);
        } else {
            $user->syncRoles([]);
        }
        
        // Refresh user to reload relationships
        $user->refresh();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success', 
                'message' => 'User updated successfully!',
                'user' => $user->load('roles')
            ]);
        }
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        $user->delete();

        if (request()->expectsJson() || request()->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully!']);
        }
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Show the form for changing user password.
     */
    public function password(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.password-form', compact('user'));
    }

    /**
     * Download CSV template for user import
     */
    public function downloadUserTemplate()
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                abort(403, 'User not authenticated.');
            }
            
            $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
            $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
            
            // Check authorization - allow admin or faculty with department permissions
            if (!$isAdmin && !($isFaculty && $user->hasPermissionTo('manage department users'))) {
                abort(403, 'Access denied. You do not have permission to download user templates.');
            }
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="user_import_template.csv"',
            ];

            $content = implode(",", [
                'name','email','password','role','department','course','id_number','first_name','middle_name','last_name','birthday','course_and_year'
            ]) . "\n" .
            // Student example row
            'Francisco Combong Villahermosa,fvillahermosa_ccs@uspf.edu.ph,changeme,student,College of Computer Studies,BSIT,202200672,Francisco,Combong,Villahermosa,2003-03-25,BSIT 4' . "\n" .
            // Faculty example row  
            'Dr. Jane Smith,faculty@uspf.edu.ph,changeme,faculty,College of Computer Studies,BSIT,,,,,,' . "\n" .
            // Admin example row
            'Admin User,admin@example.com,changeme,admin,,,,,,,,' . "\n";

            return response($content, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('Error in downloadUserTemplate: ' . $e->getMessage());
            abort(500, 'Internal server error: ' . $e->getMessage());
        }
    }

    /**
     * Import users from CSV
     */
    public function importUsers(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        // Check authorization - allow admin or faculty with department permissions
        if (!$isAdmin && !($isFaculty && $user->hasPermissionTo('manage department users'))) {
            abort(403, 'Access denied. You do not have permission to import users.');
        }
        
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        if ($handle === false) {
            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unable to read uploaded file.'], 400);
            }
            return back()->with('error', 'Unable to read uploaded file.');
        }

        $header = fgetcsv($handle);
        $normalizedHeader = array_map(fn($h) => strtolower(trim($h)), $header ?: []);

        // Required base columns
        $required = ['name','email','password','role'];
        foreach ($required as $col) {
            if (!in_array($col, $normalizedHeader, true)) {
                fclose($handle);
                if ($request->expectsJson()) {
                    return response()->json(['status' => 'error', 'message' => 'Invalid CSV headers. Required: name,email,password,role'], 400);
                }
                return back()->with('error', 'Invalid CSV headers. Required: name,email,password,role');
            }
        }

        // Optional columns including department and course
        $colIndex = fn(string $key) => array_search($key, $normalizedHeader, true);

        $created = 0; $updated = 0; $skipped = 0; $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($required)) { $skipped++; continue; }
            $name = trim($row[$colIndex('name')]);
            $email = strtolower(trim($row[$colIndex('email')]));
            $password = (string) $row[$colIndex('password')];
            $role = trim(strtolower($row[$colIndex('role')]));
            
            // Get department and course from CSV
            $department = ($idx = $colIndex('department')) !== false ? trim((string)($row[$idx] ?? '')) : null;
            $course = ($idx = $colIndex('course')) !== false ? trim((string)($row[$idx] ?? '')) : null;
            
            // For faculty users, enforce their department restrictions
            if ($isFaculty && !$isAdmin) {
                $department = $user->department; // Force faculty's department
                $course = $user->course; // Force faculty's course
            }
            
            if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$password) { $skipped++; continue; }
            if (!in_array($role, ['admin','student','faculty'], true)) { $role = 'student'; }

            $userRecord = User::where('email', $email)->first();
            if ($userRecord) {
                $userRecord->update([
                    'name' => $name,
                    'role' => $role,
                    'department' => $department,
                    'course' => $course,
                ]);
                // Sync Spatie role
                if ($role && in_array($role, ['admin', 'faculty', 'student'], true)) {
                    $userRecord->syncRoles([$role]);
                }
                $updated++;
            } else {
                $userRecord = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => $role,
                    'department' => $department,
                    'course' => $course,
                ]);
                // Assign Spatie role
                if ($role && in_array($role, ['admin', 'faculty', 'student'], true)) {
                    $userRecord->assignRole($role);
                }
                $created++;
            }

            // If student, create/update linked Student record
            if ($role === 'student' && $userRecord) {
                $idNumber = ($idx = $colIndex('id_number')) !== false ? trim((string)($row[$idx] ?? '')) : null;
                $firstName = ($idx = $colIndex('first_name')) !== false ? trim((string)($row[$idx] ?? '')) : null;
                $middleName = ($idx = $colIndex('middle_name')) !== false ? trim((string)($row[$idx] ?? '')) : null;
                $lastName = ($idx = $colIndex('last_name')) !== false ? trim((string)($row[$idx] ?? '')) : null;
                $birthday = ($idx = $colIndex('birthday')) !== false ? trim((string)($row[$idx] ?? '')) : null;
                $courseYear = ($idx = $colIndex('course_and_year')) !== false ? trim((string)($row[$idx] ?? '')) : null;

                // If first/last not provided, try to split name
                if (!$firstName && !$lastName && $name) {
                    $parts = preg_split('/\s+/', $name);
                    $firstName = $parts[0] ?? null;
                    $lastName = count($parts) > 1 ? array_pop($parts) : null;
                    $middleName = count($parts) > 1 ? trim(implode(' ', array_slice($parts, 1))) : null;
                }

                $student = Student::firstOrNew(['user_id' => $userRecord->id]);
                if ($idNumber) $student->id_number = $idNumber;
                if ($firstName) $student->first_name = $firstName;
                if ($middleName !== null) $student->middle_name = $middleName;
                if ($lastName) $student->last_name = $lastName;
                if ($birthday) $student->birthday = $birthday; // expects YYYY-MM-DD
                if ($courseYear) $student->course_and_year = $courseYear;
                $student->user_id = $userRecord->id;
                $student->save();
            }
        }
        fclose($handle);

        $msg = "Import complete. Created: $created, Updated: $updated, Skipped: $skipped";
        if ($request->expectsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    public function downloadsViews()
    {
        $user = auth()->user();
        
        // Check if user is admin
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        
        if (!$isAdmin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        // Get most viewed research (top 20)
        $mostViewed = DB::table('research_analytics')
            ->select('research_type', 'research_id', DB::raw('COUNT(*) as view_count'))
            ->where('action', 'view')
            ->groupBy('research_type', 'research_id')
            ->orderBy('view_count', 'desc')
            ->limit(20)
            ->get();

        // Get most downloaded research (top 20)
        $mostDownloaded = DB::table('research_analytics')
            ->select('research_type', 'research_id', DB::raw('COUNT(*) as download_count'))
            ->where('action', 'download')
            ->groupBy('research_type', 'research_id')
            ->orderBy('download_count', 'desc')
            ->limit(20)
            ->get();

        // Get recent downloads with purpose and notes (last 20)
        $recentDownloads = ResearchAnalytic::where('action', 'download')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Get recent approved research (last 20)
        $recentResearch = collect();
        
        // Get recent from each research type
        $recentStudent = StudentResearch::where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->research_type = 'student';
                $item->view_count = ResearchAnalytic::getViewCount('student', $item->id);
                $item->download_count = ResearchAnalytic::getDownloadCount('student', $item->id);
                return $item;
            });
        
        $recentFaculty = FacultyResearch::where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->research_type = 'faculty';
                $item->view_count = ResearchAnalytic::getViewCount('faculty', $item->id);
                $item->download_count = ResearchAnalytic::getDownloadCount('faculty', $item->id);
                return $item;
            });
        
        $recentThesis = Thesis::where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->research_type = 'thesis';
                $item->view_count = ResearchAnalytic::getViewCount('thesis', $item->id);
                $item->download_count = ResearchAnalytic::getDownloadCount('thesis', $item->id);
                return $item;
            });
        
        $recentDissertation = Dissertation::where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->research_type = 'dissertation';
                $item->view_count = ResearchAnalytic::getViewCount('dissertation', $item->id);
                $item->download_count = ResearchAnalytic::getDownloadCount('dissertation', $item->id);
                return $item;
            });

        $recentResearch = $recentResearch
            ->merge($recentStudent)
            ->merge($recentFaculty)
            ->merge($recentThesis)
            ->merge($recentDissertation)
            ->sortByDesc(function($item) {
                return $item->approved_at ?? $item->created_at;
            })
            ->take(20);

        // Enrich most viewed with research details
        $mostViewedEnriched = $mostViewed->map(function($item) {
            $research = $this->getResearchByType($item->research_type, $item->research_id);
            if ($research) {
                $research->view_count = $item->view_count;
                $research->research_type = $item->research_type;
                return $research;
            }
            return null;
        })->filter();

        // Enrich most downloaded with research details
        $mostDownloadedEnriched = $mostDownloaded->map(function($item) {
            $research = $this->getResearchByType($item->research_type, $item->research_id);
            if ($research) {
                $research->download_count = $item->download_count;
                $research->research_type = $item->research_type;
                return $research;
            }
            return null;
        })->filter();

        // Enrich recent downloads with research details and purpose/notes
        $recentDownloadsEnriched = $recentDownloads->map(function($download) {
            $research = $this->getResearchByType($download->research_type, $download->research_id);
            if ($research) {
                $research->download_purpose = $download->download_purpose;
                $research->download_notes = $download->download_notes;
                $research->download_date = $download->created_at;
                $research->research_type = $download->research_type;
                return $research;
            }
            return null;
        })->filter();

        return view('admin.downloads-views', [
            'mostViewed' => $mostViewedEnriched,
            'mostDownloaded' => $mostDownloadedEnriched,
            'recentDownloads' => $recentDownloadsEnriched,
            'recentResearch' => $recentResearch
        ]);
    }

    private function getResearchByType($type, $id)
    {
        switch ($type) {
            case 'student':
                return StudentResearch::find($id);
            case 'faculty':
                return FacultyResearch::find($id);
            case 'thesis':
                return Thesis::find($id);
            case 'dissertation':
                return Dissertation::find($id);
            default:
                return null;
        }
    }

    public function adviserApprovals()
    {
        $user = auth()->user();
        $isFaculty = $user->hasRole('faculty') || $user->role === 'faculty';
        
        if (!$isFaculty) {
            abort(403, 'Access denied. Faculty privileges required.');
        }

        // Get research where current user is the adviser and not yet approved by adviser
        $studentResearch = StudentResearch::where('adviser_id', $user->id)
            ->whereNull('adviser_approved_at')
            ->with(['user', 'adviser'])
            ->latest()
            ->get();

        $facultyResearch = FacultyResearch::where('adviser_id', $user->id)
            ->whereNull('adviser_approved_at')
            ->with(['user', 'adviser'])
            ->latest()
            ->get();

        $thesis = Thesis::where('adviser_id', $user->id)
            ->whereNull('adviser_approved_at')
            ->with(['user', 'adviser'])
            ->latest()
            ->get();

        $dissertations = Dissertation::where('adviser_id', $user->id)
            ->whereNull('adviser_approved_at')
            ->with(['user', 'adviser'])
            ->latest()
            ->get();

        return view('admin.adviser-approvals', compact(
            'studentResearch',
            'facultyResearch',
            'thesis',
            'dissertations'
        ));
    }

    public function approveAdviser(Request $request, $type, $id)
    {
        $user = auth()->user();
        $isFaculty = $user->hasRole('faculty') || $user->role === 'faculty';
        
        if (!$isFaculty) {
            abort(403, 'Access denied. Faculty privileges required.');
        }

        $research = $this->getResearchByType($type, $id);
        
        if (!$research) {
            abort(404, 'Research not found.');
        }

        // Check if current user is the adviser
        if ($research->adviser_id !== $user->id) {
            abort(403, 'Access denied. You are not the assigned adviser for this research.');
        }

        // Check if already approved by adviser
        if ($research->adviser_approved_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'This research has already been approved by the adviser.'
            ], 400);
        }

        $research->update([
            'adviser_approved_at' => now(),
            'adviser_approved_by' => $user->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Research approved by adviser successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Research approved by adviser successfully!');
    }

    public function rejectAdviser(Request $request, $type, $id)
    {
        $user = auth()->user();
        $isFaculty = $user->hasRole('faculty') || $user->role === 'faculty';
        
        if (!$isFaculty) {
            abort(403, 'Access denied. Faculty privileges required.');
        }

        $research = $this->getResearchByType($type, $id);
        
        if (!$research) {
            abort(404, 'Research not found.');
        }

        // Check if current user is the adviser
        if ($research->adviser_id !== $user->id) {
            abort(403, 'Access denied. You are not the assigned adviser for this research.');
        }

        // Check if already approved by adviser
        if ($research->adviser_approved_at) {
            return response()->json([
                'status' => 'error',
                'message' => 'This research has already been approved by the adviser.'
            ], 400);
        }

        // For rejection, we can clear the adviser_id or add a rejection note
        // For now, we'll just clear the adviser assignment
        $research->update([
            'adviser_id' => null,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Research rejected. Adviser assignment removed.'
            ]);
        }

        return redirect()->back()->with('success', 'Research rejected. Adviser assignment removed.');
    }
}
