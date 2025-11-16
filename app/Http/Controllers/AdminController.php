<?php

namespace App\Http\Controllers;

use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
                    ->merge(StudentResearch::where('status','approved')->where('department', $userDepartment)->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(FacultyResearch::where('status','approved')->where('department', $userDepartment)->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Thesis::where('status','approved')->where('department', $userDepartment)->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Dissertation::where('status','approved')->where('department', $userDepartment)->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'));
            } else {
                // Admin sees all departments
                $deptCounts = $deptCounts
                    ->merge(StudentResearch::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(FacultyResearch::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Thesis::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                    ->merge(Dissertation::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'));
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
                    ->select('program', \DB::raw('count(*) as total'))
                    ->groupBy('program')
                    ->orderByDesc('total')
                    ->limit(8)
                    ->get();
            } else {
                $programCounts = StudentResearch::where('status','approved')
                    ->select('program', \DB::raw('count(*) as total'))
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

        return view('admin.dashboard', compact(
            'pendingStudentResearch',
            'pendingFacultyResearch',
            'pendingThesis',
            'pendingDissertations',
            'monthName',
            'offset',
            'chartData',
            'chartDepartments',
            'chartDepartmentCounts',
            'chartPrograms',
            'chartProgramCounts',
            'chartTopViewed',
            'chartTopDownloaded',
            'chartTopPopular'
        ));
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
        
        $research->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

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
        
        $research->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

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
        
        $thesis->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

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
        
        $dissertation->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

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
     * Display a listing of users.
     */
    public function users(Request $request)
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || ($user->role === 'admin');
        $isFaculty = $user->hasRole('faculty') || ($user->role === 'faculty');
        
        // Check authorization - allow admin or faculty with department permissions
        if (!$isAdmin && !($isFaculty && $user->hasPermissionTo('manage department users'))) {
            $this->authorize('viewAny', User::class);
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
        $user->load('roles');
        return view('admin.users.show', compact('user'));
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
}
