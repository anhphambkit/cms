<?php
use Illuminate\Support\Facades\Session;

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

$router->get('map/location', function(){
    Session::forget('hello');
    return Session::get('hello');
});

/** @var Router $router */
$router->group(['prefix' => 'customer', 'middleware' => ['customer.guest']], function (Router $router) {
    # Login
    $router->get('login', [
		'as'         => 'public.customer.login', 
		'uses'       => 'LoginController@showLoginForm',
    ]);

    $router->post('login', [ 
		'as'         => 'public.customer.login', 
		'uses'       => 'LoginController@login',
    ]);
   
    $router->get('resend-confirmation/{email}', [
        'as'         => 'public.customer.resend_confirmation', 
        'uses'       => 'RegisterController@logout',
    ]);

    $router->get('create-account', [
        'as'         => 'public.customer.create-account', 
        'uses'       => 'RegisterController@showRegisterForm',
    ]);

    $router->post('create-account', [
        'as'         => 'public.customer.create-account', 
        'uses'       => 'RegisterController@register',
    ]);

    $router->get('confirm/{email}', [
        'as'         => 'public.customer.confirm', 
        'uses'       => 'RegisterController@confirm',
    ]);
});

$router->group(['prefix' => 'account', 'middleware' => ['customer']], function (Router $router) {
    
    $router->get('logout', [
        'as'         => 'public.customer.logout', 
        'uses'       => 'LoginController@logout',
    ]);

    $router->get('/profile', [
        'as' => 'public.customer.dashboard',
        'uses' => 'CustomerController@getMyAccount',
    ]);

    $router->post('/profile', [
        'as' => 'public.customer.dashboard',
        'uses' => 'CustomerController@postMyAccount',
    ]);
});

$router->group(['prefix' => 'order', 'middleware' => ['customer']], function (Router $router) {
    
    $router->get('detail/{id}', [
        'as'         => 'public.order.detail', 
        'uses'       => 'OrderController@myOrderDetail',
    ]);

    $router->post('resend_confirmation', [
        'as'         => 'public.order.resend_confirmation', 
        'uses'       => 'OrderController@resendConfirmation',
    ]);

    $router->get('/my-orders', [
        'as' => 'public.customer.my-orders',
        'uses' => 'OrderController@getMyOrders',
    ]);
});