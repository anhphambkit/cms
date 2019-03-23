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

$router->group(['prefix' => 'productcategory'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'productcategory.list',
        'uses' => 'ProductcategoryController@getList',
    ]);

    $router->get('/create', [
        'as' => 'productcategory.create',
        'uses' => 'ProductcategoryController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'productcategory.create',
        'uses' => 'ProductcategoryController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'productcategory.edit',
        'uses' => 'ProductcategoryController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'productcategory.edit',
        'uses' => 'ProductcategoryController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'productcategory.delete',
        'uses' => 'ProductcategoryController@getDelete',
    ]);
});

	