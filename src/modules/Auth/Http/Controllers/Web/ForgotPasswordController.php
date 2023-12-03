<?php

namespace Modules\Auth\Http\Controllers\Web;

use Modules\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Modules\Auth\Services\ResetPasswordService;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected $redirectTo = '/auth';

    protected $resetPasswordService;

    /**
     * ForgotPasswordController constructor.
     *
     * @param  ResetPasswordService  $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->middleware('guest');
        $this->resetPasswordService = $resetPasswordService;
    }

    public function showResetForm()
    {
        return view('auth::passwords.email');
    }

    public function showConfirmForm()
    {
        return view('auth::passwords.confirm');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return redirect()->route('password.email.sent')
            ->withInput($request->only('email'))
            ->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return redirect()->route('password.email.sent')
            ->withInput($request->only('email'))
            ->with('status', trans($response));
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->with(['status' => __($status)]);
    }
}
