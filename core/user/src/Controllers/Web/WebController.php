<?php
namespace Core\User\Controllers\Web;
use Illuminate\Routing\Controller;

class WebController extends Controller{
    
    /**
     * Login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(){
        return view('core-user::auth.login');
    }
}