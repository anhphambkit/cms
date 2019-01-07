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

Route::get('/', function () {
	return view('welcome');
})->name('test');

/** @var Router $router */
$router->group(['prefix' => 'auth'], function (Router $router) {
    # Login
    $router->get('login', [
		'as'         => 'login', 
		'uses'       => 'WebController@showLoginForm',
		'middleware' => 'guest', 
    ]);

    $router->post('login', [ 
		'as'         => 'post.login', 
		'uses'       => 'WebController@postLogin',
		'middleware' => 'guest', 
    ]);
   
    # Logout
    $router->get('logout', [
		'as'         => 'logout', 
		'uses'       => 'WebController@logout',
		'middleware' => 'auth', 
    ]);
});