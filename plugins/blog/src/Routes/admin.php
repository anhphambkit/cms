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

$router->group(['prefix' => 'blog/post'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.blog.list',
        'uses' => 'BlogController@getList',
    ]);

    $router->get('/create', [
        'as' => 'admin.blog.create',
        'uses' => 'BlogController@getCreate',
    ]);

    $router->post('/create', [
        'as' => 'admin.blog.create',
        'uses' => 'BlogController@postCreate',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.blog.edit',
        'uses' => 'BlogController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.blog.edit',
        'uses' => 'BlogController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.blog.delete',
        'uses' => 'BlogController@getDelete',
    ]);
});

$router->group(['prefix' => 'blog/category'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.blog.category.list',
        'uses' => 'BlogController@getList',
    ]);

    // $router->get('/create', [
    //     'as' => 'admin.blog.create',
    //     'uses' => 'BlogController@getCreate',
    // ]);

    // $router->post('/create', [
    //     'as' => 'admin.blog.create',
    //     'uses' => 'BlogController@postCreate',
    // ]);

    // $router->get('/edit/{id}', [
    //     'as' => 'admin.blog.edit',
    //     'uses' => 'BlogController@getEdit',
    // ]);

    // $router->post('/edit/{id}', [
    //     'as' => 'admin.blog.edit',
    //     'uses' => 'BlogController@postEdit',
    // ]);

    // $router->get('/delete/{id}', [
    //     'as' => 'admin.blog.delete',
    //     'uses' => 'BlogController@getDelete',
    // ]);
});

$router->group(['prefix' => 'blog/tag'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.blog.tag.list',
        'uses' => 'BlogController@getList',
    ]);

    // $router->get('/create', [
    //     'as' => 'admin.blog.create',
    //     'uses' => 'BlogController@getCreate',
    // ]);

    // $router->post('/create', [
    //     'as' => 'admin.blog.create',
    //     'uses' => 'BlogController@postCreate',
    // ]);

    // $router->get('/edit/{id}', [
    //     'as' => 'admin.blog.edit',
    //     'uses' => 'BlogController@getEdit',
    // ]);

    // $router->post('/edit/{id}', [
    //     'as' => 'admin.blog.edit',
    //     'uses' => 'BlogController@postEdit',
    // ]);

    // $router->get('/delete/{id}', [
    //     'as' => 'admin.blog.delete',
    //     'uses' => 'BlogController@getDelete',
    // ]);
});

	