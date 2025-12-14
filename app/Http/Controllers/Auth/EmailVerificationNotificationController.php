<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // #region agent log
        $mailConfig = [
            'mail_mailer_env'=>env('MAIL_MAILER'),
            'mail_mailer_config'=>config('mail.default'),
            'mail_host'=>env('MAIL_HOST'),
            'mail_port'=>env('MAIL_PORT'),
            'mail_username'=>env('MAIL_USERNAME'),
            'has_mail_password'=>!empty(env('MAIL_PASSWORD')),
            'mail_from_address'=>env('MAIL_FROM_ADDRESS'),
            'mail_from_name'=>env('MAIL_FROM_NAME'),
            'mail_from_config'=>config('mail.from'),
            'app_url'=>env('APP_URL'),
            'app_url_config'=>config('app.url'),
            'queue_connection'=>config('queue.default'),
            'queue_driver'=>env('QUEUE_CONNECTION'),
        ];
        file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_1','timestamp'=>time()*1000,'location'=>'EmailVerificationNotificationController.php:20','message'=>'Resend verification - Full mail config','data'=>array_merge($mailConfig,['user_id'=>$request->user()->id,'email'=>$request->user()->email]),'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'A,B,C'])."\n", FILE_APPEND);
        // #endregion

        try {
            // #region agent log
            $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $request->user()->id, 'hash' => sha1($request->user()->email)]);
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_2','timestamp'=>time()*1000,'location'=>'EmailVerificationNotificationController.php:28','message'=>'Generated verification URL','data'=>['user_id'=>$request->user()->id,'email'=>$request->user()->email,'verification_url'=>$verificationUrl,'url_domain'=>parse_url($verificationUrl,PHP_URL_HOST)],'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'B'])."\n", FILE_APPEND);
            // #endregion
            
            $request->user()->sendEmailVerificationNotification();
            
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_3','timestamp'=>time()*1000,'location'=>'EmailVerificationNotificationController.php:33','message'=>'Verification notification sent successfully','data'=>['user_id'=>$request->user()->id,'email'=>$request->user()->email,'queue_connection'=>config('queue.default'),'is_queued'=>config('queue.default')!=='sync'],'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'D'])."\n", FILE_APPEND);
            // #endregion
        } catch (\Exception $e) {
            // #region agent log
            file_put_contents('c:\\Users\\KBoY\\archive_uspf\\.cursor\\debug.log', json_encode(['id'=>'log_'.time().'_4','timestamp'=>time()*1000,'location'=>'EmailVerificationNotificationController.php:37','message'=>'Error sending verification','data'=>['user_id'=>$request->user()->id,'email'=>$request->user()->email,'error'=>$e->getMessage(),'class'=>get_class($e),'file'=>$e->getFile(),'line'=>$e->getLine(),'trace'=>substr($e->getTraceAsString(),0,1000)],'sessionId'=>'debug-session','runId'=>'run1','hypothesisId'=>'E'])."\n", FILE_APPEND);
            // #endregion
            \Log::error('Email verification resend error: ' . $e->getMessage(), ['exception' => $e]);
        }

        return back()->with('status', 'verification-link-sent');
    }
}
