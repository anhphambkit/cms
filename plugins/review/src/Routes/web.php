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

$router->group(['prefix' => 'review', 'middleware' => ['customer']], function (Router $router) {
    
    $router->post('review/{productId}', [
        'as'         => 'public.review.create', 
        'uses'       => 'ReviewController@postReview',
    ]);

    $router->post('comment/{reviewId}', [
        'as'         => 'public.review.comment.create', 
        'uses'       => 'ReviewController@postCommentReview',
    ]);

});