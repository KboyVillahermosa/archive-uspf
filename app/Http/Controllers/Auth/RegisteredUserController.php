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

        // #region agent log
        $mailConfig = [
            'mail_mailer_env' => env('MAIL_MAILER'),
            'mail_mailer_config' => config('mail.default'),
            'mail_host' => env('MAIL_HOST'),
            'mail_port' => env('MAIL_PORT'),
            'mail_username' => env('MAIL_USERNAME'),
            'has_mail_password' => !empty(env('MAIL_PASSWORD')),
            'mail_from_address' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_from_config' => config('mail.from'),
            'app_url' => env('APP_URL'),
            'app_url_config' => config('app.url'),
            'queue_connection' => config('queue.default'),
            'queue_driver' => env('QUEUE_CONNECTION'),
        ];
        file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_reg1','timestamp'=>time()*1000,'location'=>'RegisteredUserController.php:88','message'=>'Registration - Full mail config before sending','data'=>array_merge($mailConfig,['user_id'=>$user->id,'email'=>$user->email]),'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A,B,C'])."\n", FILE_APPEND);
        // #endregion

        // Send verification email
        try {
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_reg2','timestamp'=>time()*1000,'location'=>'RegisteredUserController.php:95','message'=>'Dispatching Registered event','data'=>['user_id'=>$user->id,'email'=>$user->email,'event'=>'Registered'],'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'D'])."\n", FILE_APPEND);
            // #endregion
            
            event(new Registered($user));
            
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_reg3','timestamp'=>time()*1000,'location'=>'RegisteredUserController.php:100','message'=>'Registered event dispatched successfully','data'=>['user_id'=>$user->id,'email'=>$user->email,'queue_connection'=>config('queue.default'),'is_queued'=>config('queue.default')!=='sync'],'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'D'])."\n", FILE_APPEND);
            // #endregion
        } catch (\Exception $e) {
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_reg4','timestamp'=>time()*1000,'location'=>'RegisteredUserController.php:105','message'=>'Error dispatching Registered event','data'=>['user_id'=>$user->id,'email'=>$user->email,'error'=>$e->getMessage(),'class'=>get_class($e),'file'=>$e->getFile(),'line'=>$e->getLine()],'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'E'])."\n", FILE_APPEND);
            // #endregion
            \Log::error('Registration email error: ' . $e->getMessage(), ['exception' => $e]);
        }

        // Auto-login user so they can access verification notice page
        Auth::login($user);

        // Redirect to email verification notice
        return redirect()->route('verification.notice');
    }
}
