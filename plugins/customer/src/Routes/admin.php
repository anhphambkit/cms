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

$router->group(['prefix' => 'order'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.order.list',
        'uses' => 'OrderController@getList',
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.order.edit',
        'uses' => 'OrderController@getEdit',
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.order.edit',
        'uses' => 'OrderController@postEdit',
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.order.delete',
        'uses' => 'OrderController@getDelete',
    ]);
});

$router->group(['prefix' => 'manage-order'], function (Router $router) {
    
    $router->post('resend_confirmation/{id}', [
        'as'         => 'admin.order.resend_confirmation', 
        'uses'       => 'ManageOrderController@resendConfirmation',
    ]);
});