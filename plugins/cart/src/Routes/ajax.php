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

$router->group(['prefix' => 'cart'], function (Router $router) {

    $router->post('/update-product-in-cart', 'CartController@updateProductsInCartOfCustomer')->name('ajax.cart.update_product_in_cart');
});