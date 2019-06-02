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

/** @var Router $router */
$router->group(['prefix' => 'design-ideal'], function (Router $router) {
    $router->get('/', [
        'as'         => 'public.design-ideal',
        'uses'       => 'DesignIdeaController@pageDesignIdeal',
    ]);

    $router->group(['prefix' => 'business-types/{businessType}'], function (Router $router) {
        $router->get('/', [
            'as'         => 'public.design-ideal.business-type',
            'uses'       => 'DesignIdeaController@pageDesignIdealOfBusinessType',
        ]);

        $router->get('/get-all-rooms', [
            'as'         => 'public.design-ideal.business-type.space.all-rooms',
            'uses'       => 'DesignIdeaController@pageAllRoomsDesignIdealOfBusinessType',
        ]);

        $router->group(['prefix' => 'spaces/{space}'], function (Router $router) {
            $router->get('/', [
                'as'         => 'public.design-ideal.business-type.space',
                'uses'       => 'DesignIdeaController@pageDesignIdealOfSpace',
            ]);
        });

    });

    $router->get('/list', [
        'as'         => 'public.design-ideal.list',
        'uses'       => 'DesignIdeaController@pageDesignIdealList',
    ]);

    $router->get('/detail/{url}', [
        'as'         => 'public.design-ideal.detail_look_book',
        'uses'       => 'DesignIdeaController@pageDetailDesignIdea',
    ]);
});

/** @var Router $router */
$router->group(['prefix' => 'product'], function (Router $router) {
    $router->get('/detail/{url}', [
        'as'         => 'public.product.detail',
        'uses'       => 'ProductController@getProductDetail',
    ]);
});

$router->group(['prefix' => 'product/checkout', 'middleware' => ['customer']], function (Router $router) {
    
    $router->get('/', [
        'as'         => 'public.product.checkout', 
        'uses'       => 'CheckoutController@getCheckout',
    ]);

    $router->post('/', [
        'as'         => 'public.product.checkout', 
        'uses'       => 'CheckoutController@postCheckout',
    ]);

    $router->post('credit-card', [
        'as'         => 'public.product.checkout.credit', 
        'uses'       => 'CheckoutController@postCheckoutCredit',
    ]);

    $router->get('/paypal/callback', [
		'as'         => 'public.product.checkout.paypal.callback', 
		'uses'       => 'CheckoutController@callbackPaypalForm',
    ]);
});