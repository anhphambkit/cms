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

    $router->get('/get-products-by-category', [
        'as' => 'ajax.admin.get_products_by_category',
        'uses' => 'Admin\ProductController@getProductsByCategory',
    ]);

    $router->get('/get-spaces-by-business-type', [
        'as' => 'ajax.admin.get_spaces_by_business_type',
        'uses' => 'Admin\ProductController@getSpacesByBusinessType',
    ]);

    $router->get('/get-all-spaces', [
        'as' => 'ajax.admin.get_all_spaces',
        'uses' => 'Admin\ProductController@getAllSpaces',
    ]);

    $router->get('/get-default-business-type', [
        'as' => 'ajax.admin.get_default_business_type',
        'uses' => 'Admin\ProductController@getDefaultBusinessType',
    ]);

});

$router->group(['prefix' => 'product'], function (Router $router) {

    $router->get('/get-overview-info-product-popup', [
        'as' => 'ajax.product.get_overview_info_product_popup',
        'uses' => 'ProductController@getOverviewInfoProductPopup',
    ]);

    $router->get('/get-detail-info-product', [
        'as' => 'ajax.product.get_detail_info_product',
        'uses' => 'ProductController@getDetailInfoProduct',
    ]);

    $router->post('/add-to-cart', 'ProductController@addOrUpdateProductsToCartOfCustomer')->name('ajax.product.add_to_cart');

    $router->post('/add-or-remove-product-to-quick-list', 'ProductController@addOrRemoveProductToQuickList')->name('ajax.product.add_or_remove_product_to_quick_list');
    $router->post('/save-product-for-later', 'ProductController@saveProductForLater')->name('ajax.product.save_product_for_later');
    $router->post('/move-product-to-cart', 'ProductController@moveProductToCart')->name('ajax.product.move_product_to_cart');
    $router->post('/delete-product-saved', 'ProductController@deleteProductSaved')->name('ajax.product.delete_product_saved');

    $router->post('/add-coupon', 'ProductController@addCoupon')->name('ajax.product.add_coupon');
    $router->delete('/delete-coupon', 'ProductController@deleteCouponInCart')->name('ajax.product.delete_coupon');
});