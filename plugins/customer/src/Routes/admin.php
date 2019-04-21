<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
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
    
    $router->get('/', [
        'as' => 'admin.customer.list',
        'uses' => 'CustomerController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.customer.create',
        'uses' => 'CustomerController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.customer.create',
        'uses' => 'CustomerController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.customer.edit',
        'uses' => 'CustomerController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.customer.edit',
        'uses' => 'CustomerController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.customer.delete',
        'uses' => 'CustomerController@getDelete',
    ]);
    
});

	