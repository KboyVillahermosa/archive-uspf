<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $departments = Department::orderBy('name')->get();
        return view('auth.register', compact('departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate USPF email format
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                'regex:/^[a-z0-9_]+_[a-z]+@uspf\.edu\.ph$/',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department' => ['required', 'exists:departments,id'],
            'program' => ['required', 'exists:programs,id'],
        ], [
            'email.regex' => 'Email must be in the format: username_department@uspf.edu.ph (e.g., fvillahermosa_ccs@uspf.edu.ph)',
            'department.required' => 'Please select a department.',
            'program.required' => 'Please select a program/course.',
        ]);

        // Verify that the program belongs to the selected department
        $program = Program::findOrFail($request->program);
        if ($program->department_id != $request->department) {
            throw ValidationException::withMessages([
                'program' => ['The selected program does not belong to the selected department.'],
            ]);
        }

        // Get department and program names
        $department = Department::findOrFail($request->department);
        $programName = $program->name;

        // Create full name from first and last name
        $fullName = trim($request->first_name . ' ' . $request->last_name);

        $user = User::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => 'active',
            'department' => $department->name,
            'course' => $programName,
            'email_verified_at' => null, // Require email verification
        ]);

        // Assign student role
        $user->assignRole('student');

        // Send verification email
        event(new Registered($user));

        // Auto-login user so they can access verification notice page
        Auth::login($user);

        // Redirect to email verification notice
        return redirect()->route('verification.notice');
    }
}
