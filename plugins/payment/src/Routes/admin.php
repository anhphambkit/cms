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

$router->group(['prefix' => 'payment'], function (Router $router) {
    
    $router->get('/', [
        'as' => 'admin.payment.list',
        'uses' => 'PaymentController@getList',
        'middleware' => 'access:payment.list'
    ]);

    $router->get('/create', [
        'as' => 'admin.payment.create',
        'uses' => 'PaymentController@getCreate',
        'middleware' => 'access:false'
    ]);

    $router->post('/create', [
        'as' => 'admin.payment.create',
        'uses' => 'PaymentController@postCreate',
        'middleware' => 'access:false'
    ]);

    $router->get('/edit/{id}', [
        'as' => 'admin.payment.edit',
        'uses' => 'PaymentController@getEdit',
        'middleware' => 'access:payment.edit'
    ]);

    $router->post('/edit/{id}', [
        'as' => 'admin.payment.edit',
        'uses' => 'PaymentController@postEdit',
        'middleware' => 'access:payment.edit'
    ]);

    $router->get('/delete/{id}', [
        'as' => 'admin.payment.delete',
        'uses' => 'PaymentController@getDelete',
        'middleware' => 'access:payment.delete'
    ]);
});

	