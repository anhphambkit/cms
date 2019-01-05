<?php
namespace Core\User\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Core\User\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;

class WebController extends BasePublicController{
    
    /**
     * Define login credential
     * @var string
     */
    protected $username = 'email';

    /**
     * Login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(){

        return view('core-user::auth.login');
    }

    /**
     * Validate login system
     * @return mixed
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = (bool) $request->get('remember_me', false);

        $error = $this->auth->login($credentials, $remember);
        
        if ($error) {
            throw ValidationException::withMessages([
                $this->username => [$error],
            ]);
        }

        return redirect()->intended(route(REDIRECT_AFTER_LOGIN))
                ->withSuccess(__('Logged'));
    }
}