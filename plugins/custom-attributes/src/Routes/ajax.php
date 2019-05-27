<?php

/*
|--------------------------------------------------------------------------
| Ajax Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;

$router->group(['prefix' => 'admin'], function (Router $router) {

    $router->get('/get-list-value-custom-attributes', [
        'as' => 'ajax.admin.get_list_value_custom_attributes',
        'uses' => 'Admin\CustomAttributesController@getListValueCustomAttributes',
    ]);

    $router->get('/get-custom-attributes', [
        'as' => 'ajax.admin.get_custom_attributes',
        'uses' => 'Admin\CustomAttributesController@getCustomAttributes',
    ]);

});