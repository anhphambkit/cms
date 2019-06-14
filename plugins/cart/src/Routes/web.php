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

$router->get('/cart', 'CartController@cart')->name('public.cart')->middleware('customer');

///************ Router Shop ************** */
//Route::prefix('shop')->group(function () {
//    // Shop Home:
//    Route::get('/', 'Shop\ShopController@index')->name('client.shop.index');
//
//    // Cart Page
//    Route::get('/complete-order', 'Shop\ShopController@completeOrder')->name('client.shop.complete_order');
//
//    // Check out:
//    Route::prefix('checkout')->group(function () {
//        Route::get('/shipping', 'Shop\ShopController@checkoutShipping')->name('client.shop.checkout_shipping');
//        Route::get('/payment', 'Shop\ShopController@checkoutPayment')->name('client.shop.checkout_payment');
//    });
//
//    // Product category
//    Route::get('/category/{urlCategory}', 'Shop\ShopController@viewCategoryPage')->name('client.shop.category_page');
//
//    /************ Router Product ************** */
//    Route::prefix('product')->group(function () {
//        // Product Detail:
//        Route::get('/detail/{urlProduct}', 'Shop\ShopController@viewDetailProduct')->name('client.product.detail');
//    });
//});