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

$router->group(['prefix' => 'review'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.review.list',
        'uses' => 'ReviewController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.review.create',
        'uses' => 'ReviewController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.review.create',
        'uses' => 'ReviewController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.review.edit',
        'uses' => 'ReviewController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.review.edit',
        'uses' => 'ReviewController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.review.delete',
        'uses' => 'ReviewController@getDelete',
    ]);
});

	