<?php

namespace Modules\Auth\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Constants\AuthStatusConst;
use Modules\Auth\Services\UserService;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $userService;

    protected $redirectTo = '/cp/users';

    public function __construct(UserService $userService)
    {
        $this->middleware('guest')->except('logout');
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        return view('auth::auth.login');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        $credentials['status'] = AuthStatusConst::STATUS_USER_ENABLE;

        return $this->guard()->attempt($credentials, $request->filled('remember'));
    }

    public function authenticated(Request $request, $user)
    {
        if (session()->has('url.intended')) {
            $url = session()->get('url.intended');
            session()->forget('url.intended');

            return redirect($url);
        }

        return redirect(route('cp.users.index'));
    }

    /**
     * @param  Request  $request
     * @return bool|JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);

            return false;
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        if (fn_auth()->hasRoleName(AuthConst::ROLE_SUPER_ADMIN)) {
            Session::put('adminId', auth()->user()->id);
        }

        $this->userService->addLastLogin(auth()->user()->id);
        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth::message.Login fail')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect(route('login'));
    }
}
