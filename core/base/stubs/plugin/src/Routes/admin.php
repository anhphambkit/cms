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

$router->group(['prefix' => '{plugin}'], function (Router $router) {
    
    $router->get('/', [
        'as' => '{plugin}.list',
        'uses' => '{Plugin}Controller@getList',
    ]);

    $router->get('/create', [
        'as' => '{plugin}.create',
        'uses' => '{Plugin}Controller@getCreate',
    ]);

    $router->post('/create', [
        'as' => '{plugin}.create',
        'uses' => '{Plugin}Controller@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => '{plugin}.edit',
        'uses' => '{Plugin}Controller@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => '{plugin}.edit',
        'uses' => '{Plugin}Controller@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => '{plugin}.delete',
        'uses' => '{Plugin}Controller@getDelete',
    ]);
});

	