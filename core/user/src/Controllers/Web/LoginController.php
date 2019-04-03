<?php

namespace Core\User\Controllers\Web;

use Core\Base\Controllers\Web\BasePublicController;
use Core\User\Requests\LoginRequest;
use Core\Master\Responses\BaseHttpResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use AclManager;

class LoginController extends BasePublicController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * @var BaseHttpResponse
     */
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @param BaseHttpResponse $response
     */
    public function __construct(BaseHttpResponse $response)
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->redirectTo = config('core-user.acl.admin_dir');
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Sang Nguyen
     */
    public function showLoginForm()
    {
        page_title()->setTitle(trans('core-user::auth.login_title'));
        return view('core-user::auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return BaseHttpResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Validation\ValidationException
     * @author Sang Nguyen
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        $user = AclManager::getUserRepository()->getFirstBy(['username' => $request->input($this->username())]);
        if (!empty($user)) {
            if (!AclManager::getActivationRepository()->completed($user)) {
                return $this->response
                    ->setError()
                    ->setMessage(trans('core-user::auth.login.not_active'));
            }
        }

        if ($this->attemptLogin($request)) {
            AclManager::getUserRepository()->update(['id' => $user->id], ['last_login' => now(config('app.timezone'))]);
            if (!session()->has('url.intended')) {
                session()->flash('url.intended', url()->current());
            }
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @return string
     * @author Sang Nguyen
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return BaseHttpResponse
     */
    public function logout(Request $request)
    {
        do_action(AUTH_ACTION_AFTER_LOGOUT_SYSTEM, AUTH_MODULE_SCREEN_NAME, $request, Auth::user());

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->response
            ->setNextUrl(route('access.login'))
            ->setMessage(trans('core-user::auth.login.logout_success'));
    }
}
