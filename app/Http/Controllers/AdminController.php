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

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingStudentResearch = StudentResearch::where('status', 'pending')->count();
        $pendingFacultyResearch = FacultyResearch::where('status', 'pending')->count();
        $pendingThesis = Thesis::where('status', 'pending')->count();
        $pendingDissertations = Dissertation::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'pendingStudentResearch',
            'pendingFacultyResearch',
            'pendingThesis',
            'pendingDissertations'
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

        return redirect()->back()->with('success', 'Student research approved successfully!');
    }

    public function rejectStudentResearch(Request $request, $id)
    {
        $research = StudentResearch::findOrFail($id);
        $research->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

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

        return redirect()->back()->with('success', 'Faculty research approved successfully!');
    }

    public function rejectFacultyResearch(Request $request, $id)
    {
        $research = FacultyResearch::findOrFail($id);
        $research->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

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

        return redirect()->back()->with('success', 'Thesis approved successfully!');
    }

    public function rejectThesis(Request $request, $id)
    {
        $thesis = Thesis::findOrFail($id);
        $thesis->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

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

        return redirect()->back()->with('success', 'Dissertation approved successfully!');
    }

    public function rejectDissertation(Request $request, $id)
    {
        $dissertation = Dissertation::findOrFail($id);
        $dissertation->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Dissertation rejected.');
    }

    /**
     * List all users with pagination
     */
    public function users(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
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
            return back()->with('error', 'Unable to read uploaded file.');
        }

        $header = fgetcsv($handle);
        $normalizedHeader = array_map(fn($h) => strtolower(trim($h)), $header ?: []);

        // Required base columns
        $required = ['name','email','password','role'];
        foreach ($required as $col) {
            if (!in_array($col, $normalizedHeader, true)) {
                fclose($handle);
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
                $updated++;
            } else {
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role' => $role,
                ]);
                $created++;
                $user = User::where('email', $email)->first();
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

        return back()->with('success', "Import complete. Created: $created, Updated: $updated, Skipped: $skipped");
    }
}
