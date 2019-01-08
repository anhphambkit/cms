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

$router->group(['prefix' =>'user'], function (Router $router) {
   
    $router->get('/users', [
        'as' => 'admin.user.index',
        'uses' => 'UserController@index',
        'middleware' => 'access:user.index'
    ]);

    $router->get('/search', [
        'as' => 'admin.user.search',
        'uses' => 'UserController@search',
        'middleware' => 'access:user.search'
    ]);
    
});

$router->group(['prefix' =>'role'], function (Router $router) {
   
    $router->get('/roles', [
        'as' => 'admin.role.index',
        'uses' => 'RoleController@index',
        'middleware' => 'access:role.index'
    ]);

    $router->get('/roles/assign', [
        'as' => 'admin.roles.assign',
        'uses' => 'RoleController@index',
        'middleware' => 'access:role.assign'
    ]);

    $router->get('/roles/list', [
        'as' => 'admin.roles.list.json',
        'uses' => 'RoleController@index',
        'middleware' => 'access:role.list'
    ]);
});


