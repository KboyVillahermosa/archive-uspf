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
        $pendingStudentResearch = StudentResearch::where('status', 'pending')->count();
        $pendingFacultyResearch = FacultyResearch::where('status', 'pending')->count();
        $pendingThesis = Thesis::where('status', 'pending')->count();
        $pendingDissertations = Dissertation::where('status', 'pending')->count();

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
            $deptCounts = $deptCounts
                ->merge(StudentResearch::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                ->merge(FacultyResearch::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                ->merge(Thesis::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'))
                ->merge(Dissertation::where('status','approved')->select('department', \DB::raw('count(*) as total'))->groupBy('department')->pluck('total','department'));

            $departmentToCount = [];
            foreach ($deptCounts as $dept => $count) {
                if (!$dept) continue;
                $departmentToCount[$dept] = ($departmentToCount[$dept] ?? 0) + (int) $count;
            }
            arsort($departmentToCount);
            $chartDepartments = array_slice(array_keys($departmentToCount), 0, 8);
            $chartDepartmentCounts = array_map(fn($k) => $departmentToCount[$k], $chartDepartments);

            $programCounts = StudentResearch::where('status','approved')
                ->select('program', \DB::raw('count(*) as total'))
                ->groupBy('program')
                ->orderByDesc('total')
                ->limit(8)
                ->get();
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

            $hydrate = function($rows) {
                $items = [];
                foreach ($rows as $r) {
                    $model = null; $title = null;
                    if ($r->research_type === 'student') $model = StudentResearch::find($r->research_id);
                    elseif ($r->research_type === 'faculty') $model = FacultyResearch::find($r->research_id);
                    elseif ($r->research_type === 'thesis') $model = Thesis::find($r->research_id);
                    elseif ($r->research_type === 'dissertation') $model = Dissertation::find($r->research_id);
                    if (!$model) continue;
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
            $daily = \DB::table('research_analytics')
                ->select(
                    \DB::raw('DATE(created_at) as day'),
                    'research_type',
                    \DB::raw("SUM(CASE WHEN action='view' THEN 1 ELSE 0 END) as views")
                )
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->groupBy(\DB::raw('DATE(created_at)'), 'research_type')
                ->orderBy('day')
                ->get();

            // Initialize each day
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

            foreach ($daily as $row) {
                $key = (string) $row->day;
                if (!isset($days[$key])) continue;
                $type = $row->research_type;
                if (!in_array($type, ['student','faculty','thesis','dissertation'], true)) continue;
                $days[$key][$type] = (int) $row->views;
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
        $studentResearch = StudentResearch::where('status', 'pending')->with('user')->latest()->get();
        $facultyResearch = FacultyResearch::where('status', 'pending')->with('user')->latest()->get();
        $thesis = Thesis::where('status', 'pending')->with('user')->latest()->get();
        $dissertations = Dissertation::where('status', 'pending')->with('user')->latest()->get();

        return view('admin.pending-research', compact(
            'studentResearch',
            'facultyResearch',
            'thesis',
            'dissertations'
        ));
    }

    public function approveStudentResearch(Request $request, $id)
    {
        $research = StudentResearch::findOrFail($id);
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
        $research = StudentResearch::findOrFail($id);
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
        $research = FacultyResearch::findOrFail($id);
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
        $research = FacultyResearch::findOrFail($id);
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
        $thesis = Thesis::findOrFail($id);
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
        $thesis = Thesis::findOrFail($id);
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
        $dissertation = Dissertation::findOrFail($id);
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
        $dissertation = Dissertation::findOrFail($id);
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
        $this->authorize('viewAny', User::class);
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|exists:roles,name',
            'status' => 'nullable|in:active,inactive',
        ], [
            'role.exists' => 'The selected role does not exist.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 'active',
            'role' => $request->role ?? 'student',
        ]);

        // Assign Spatie role
        if ($request->filled('role') && $request->role !== '') {
            $user->assignRole($request->role);
        }
        
        // Refresh user to reload relationships
        $user->refresh();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success', 
                'message' => 'User created successfully!',
                'user' => $user->load('roles')
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
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_import_template.csv"',
        ];

        $content = implode(",", [
            'name','email','password','role','id_number','first_name','middle_name','last_name','birthday','course_and_year'
        ]) . "\n" .
        // Student example row
        'Francisco Combong Villahermosa,fvillahermosa_ccs@uspf.edu.ph,changeme,student,202200672,Francisco,Combong,Villahermosa,2003-03-25,BSIT 4' . "\n" .
        // Admin example row
        'Admin User,admin@example.com,changeme,admin,,,,,,' . "\n";

        return response($content, 200, $headers);
    }

    /**
     * Import users from CSV
     */
    public function importUsers(Request $request)
    {
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

        // Optional student columns
        $colIndex = fn(string $key) => array_search($key, $normalizedHeader, true);

        $created = 0; $updated = 0; $skipped = 0; $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($required)) { $skipped++; continue; }
            $name = trim($row[$colIndex('name')]);
            $email = strtolower(trim($row[$colIndex('email')]));
            $password = (string) $row[$colIndex('password')];
            $role = trim(strtolower($row[$colIndex('role')]));
            if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$password) { $skipped++; continue; }
            if (!in_array($role, ['admin','student','faculty'], true)) { $role = 'student'; }

            $user = User::where('email', $email)->first();
            if ($user) {
                $user->update([
                    'name' => $name,
                    'role' => $role,
                ]);
                // Sync Spatie role
                if ($role && in_array($role, ['admin', 'faculty', 'student'], true)) {
                    $user->syncRoles([$role]);
                }
                $updated++;
            } else {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => $role,
                ]);
                // Assign Spatie role
                if ($role && in_array($role, ['admin', 'faculty', 'student'], true)) {
                    $user->assignRole($role);
                }
                $created++;
            }

            // If student, create/update linked Student record
            if ($role === 'student' && $user) {
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

                $student = Student::firstOrNew(['user_id' => $user->id]);
                if ($idNumber) $student->id_number = $idNumber;
                if ($firstName) $student->first_name = $firstName;
                if ($middleName !== null) $student->middle_name = $middleName;
                if ($lastName) $student->last_name = $lastName;
                if ($birthday) $student->birthday = $birthday; // expects YYYY-MM-DD
                if ($courseYear) $student->course_and_year = $courseYear;
                $student->user_id = $user->id;
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
