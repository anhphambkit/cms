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
Route::get('/', function () {
	return view('core-base::base');
});

Route::get('auth/login', 'WebController@showLoginForm')->name('login')->middleware('guest');
Route::post('auth/login', '\App\Http\Controllers\Auth\LoginController@login')->name('post.login');
Route::get('auth/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

