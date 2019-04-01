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

$router->group(['prefix' => 'productlookbook'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'productlookbook.list',
        'uses' => 'ProductlookbookController@getList',
    ]);

    $router->get('/create', [
        'as' => 'productlookbook.create',
        'uses' => 'ProductlookbookController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'productlookbook.create',
        'uses' => 'ProductlookbookController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'productlookbook.edit',
        'uses' => 'ProductlookbookController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'productlookbook.edit',
        'uses' => 'ProductlookbookController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'productlookbook.delete',
        'uses' => 'ProductlookbookController@getDelete',
    ]);
});

	