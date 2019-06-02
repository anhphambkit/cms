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

$router->group(['prefix' => 'cart'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.cart.list',
        'uses' => 'CartController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.cart.create',
        'uses' => 'CartController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.cart.create',
        'uses' => 'CartController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.cart.edit',
        'uses' => 'CartController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.cart.edit',
        'uses' => 'CartController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.cart.delete',
        'uses' => 'CartController@getDelete',
    ]);
});

	