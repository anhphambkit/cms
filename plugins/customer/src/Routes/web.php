<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;


/** @var Router $router */
$router->group(['prefix' => 'customer'], function (Router $router) {
    # Login
    $router->get('login', [
		'as'         => 'public.customer.login', 
		'uses'       => 'LoginController@showLoginForm',
    ]);

    $router->post('login', [ 
		'as'         => 'public.customer.login', 
		'uses'       => 'LoginController@login',
    ]);

    $router->post('register', [ 
		'as'         => 'public.customer.register', 
		'uses'       => 'WebController@showRegisterForm',
		'middleware' => 'guest', 
    ]);
   
    # Logout
    $router->get('logout', [
		'as'         => 'public.customer.logout', 
		'uses'       => 'LoginController@logout',
		'middleware' => 'auth', 
    ]);
});


$router->group(['prefix' => 'customer'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'public.customer.dashboard',
        'uses' => 'CustomerController@dashboard',
    ]);

});