<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;

$router->get('/', [
	'as'         => 'homepage', 
	'uses'       => 'PublicController@homepage',
]);


/** @var Router $router */
$router->group(['prefix' => 'design-ideal'], function (Router $router) {
    # Login
    $router->get('/', [
		'as'         => 'public.design-ideal', 
		'uses'       => 'PublicController@pageDesignIdeal',
    ]);

    $router->get('/list', [
		'as'         => 'public.design-ideal.list', 
		'uses'       => 'PublicController@pageDesignIdealList',
    ]);
});
