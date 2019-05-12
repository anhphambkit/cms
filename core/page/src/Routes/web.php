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
    $router->get('/', [
		'as'         => 'public.design-ideal', 
		'uses'       => 'PublicController@pageDesignIdeal',
    ]);

    $router->group(['prefix' => 'business-types/{businessType}'], function (Router $router) {
        $router->get('/', [
            'as'         => 'public.design-ideal.business-type',
            'uses'       => 'PublicController@pageDesignIdealOfBusinessType',
        ]);

        $router->get('/get-all-rooms', [
            'as'         => 'public.design-ideal.business-type.space.all-rooms',
            'uses'       => 'PublicController@pageAllRoomsDesignIdealOfBusinessType',
        ]);

        $router->group(['prefix' => 'spaces/{space}'], function (Router $router) {
            $router->get('/', [
                'as'         => 'public.design-ideal.business-type.space',
                'uses'       => 'PublicController@pageDesignIdealOfSpace',
            ]);
        });

    });

    $router->get('/list', [
		'as'         => 'public.design-ideal.list', 
		'uses'       => 'PublicController@pageDesignIdealList',
    ]);

    $router->get('/detail/{url}', [
        'as'         => 'public.design-ideal.detail_look_book',
        'uses'       => 'PublicController@pageDetailDesignIdea',
    ]);
});
