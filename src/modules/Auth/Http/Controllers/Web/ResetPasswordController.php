<?php

namespace Modules\Auth\Http\Controllers\Web;

use Modules\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Modules\Auth\Services\ResetPasswordService;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $resetPasswordService;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * ResetPasswordController constructor.
     *
     * @param ResetPasswordService $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->middleware('guest');
        $this->resetPasswordService = $resetPasswordService;
        $this->redirectTo           = "/cp";
    }

    public function showResetForm(Request $request)
    {
        $email       = $request->email;
        $checkExpire = $this->resetPasswordService->checkExpire($email);
        if (is_null($checkExpire)) {
            return view('auth::passwords.expire_time');
        } else {
            return view('auth::passwords.reset')->with(
                ['token' => $request->token, 'email' => $request->email]
            );
        }
    }

    protected function resetPassword($user, $password)
    {
        $this->resetPasswordService->resetPassword($user, $password);
    }

    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8|max:20',
        ];
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $broker = $this->broker();

        $response = $broker->reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', trans('Update completed'));
        } else {
            return redirect()->route('login')->with('fail', trans('Update failed'));
        }
    }
}
