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

$router->group(['prefix' => 'product'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'product.list',
        'uses' => 'ProductController@getList',
    ]);

    $router->get('/create', [
        'as' => 'product.create',
        'uses' => 'ProductController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'product.create',
        'uses' => 'ProductController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'product.edit',
        'uses' => 'ProductController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'product.edit',
        'uses' => 'ProductController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'product.delete',
        'uses' => 'ProductController@getDelete',
    ]);
});

	