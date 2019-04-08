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
        'as' => 'admin.product.list',
        'uses' => 'ProductController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.product.create',
        'uses' => 'ProductController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.product.edit',
        'uses' => 'ProductController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.product.edit',
        'uses' => 'ProductController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.product.delete',
        'uses' => 'ProductController@getDelete',
    ]);

    $router->group(['prefix' => 'brand'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.brand.list',
            'uses' => 'ProductController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.brand.create',
            'uses' => 'ProductController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.brand.create',
            'uses' => 'ProductController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.brand.edit',
            'uses' => 'ProductController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.brand.edit',
            'uses' => 'ProductController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.brand.delete',
            'uses' => 'ProductController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'color'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.color.list',
            'uses' => 'ProductController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.color.create',
            'uses' => 'ProductController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.color.create',
            'uses' => 'ProductController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.color.edit',
            'uses' => 'ProductController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.color.edit',
            'uses' => 'ProductController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.color.delete',
            'uses' => 'ProductController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'business-type'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.business-type.list',
            'uses' => 'ProductController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.business-type.create',
            'uses' => 'ProductController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.business-type.create',
            'uses' => 'ProductController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.business-type.edit',
            'uses' => 'ProductController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.business-type.edit',
            'uses' => 'ProductController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.business-type.delete',
            'uses' => 'ProductController@getDelete',
        ]);

    });

    $router->group(['prefix' => 'collection'], function (Router $router) {

        $router->get('/', [
            'as' => 'admin.product.collection.list',
            'uses' => 'ProductController@getList',
        ]);

        $router->get('/create', [
            'as' => 'admin.product.collection.create',
            'uses' => 'ProductController@getCreate',
        ]);

        $router->post('/create', [
            'as' => 'admin.product.collection.create',
            'uses' => 'ProductController@postCreate',
        ]);

        $router->get('/edit/{id}', [
            'as' => 'admin.product.collection.edit',
            'uses' => 'ProductController@getEdit',
        ]);

        $router->post('/edit/{id}', [
            'as' => 'admin.product.collection.edit',
            'uses' => 'ProductController@postEdit',
        ]);

        $router->get('/delete/{id}', [
            'as' => 'admin.product.collection.delete',
            'uses' => 'ProductController@getDelete',
        ]);

    });
});

	