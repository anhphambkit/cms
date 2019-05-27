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

$router->group(['prefix' => 'payment', 'middleware' => ['customer']], function (Router $router) {
    
    $router->get('/paypal', [
		'as'         => 'payment.paypal', 
		'uses'       => 'PaymentController@showPaypalForm',
    ]);

    $router->get('/paypal/callback', [
		'as'         => 'payment.paypal.callback', 
		'uses'       => 'PaymentController@callbackPaypalForm',
    ]);

    $router->get('/paypal/credit', [
		'as'         => 'payment.credit', 
		'uses'       => 'PaypalCreditController@testCreditCard',
    ]);

    $router->get('/paypal/express', [
		'as'         => 'payment.paypal.express', 
		'uses'       => 'PaypalExpressController@testExpressCheckout',
    ]);

    $router->get('/paypal/express/callback', [
		'as'         => 'payment.paypal.express.callback', 
		'uses'       => 'PaypalExpressController@testExpressCheckoutCallback',
    ]);
});