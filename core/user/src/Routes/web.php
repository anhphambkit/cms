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
})->name('test')->middleware('access:dashboard.index');

Route::get('auth/login', 'WebController@showLoginForm')->name('login')->middleware('guest');
Route::post('auth/login', 'WebController@postLogin')->name('post.login');
Route::get('auth/logout', 'WebController@logout')->name('logout');