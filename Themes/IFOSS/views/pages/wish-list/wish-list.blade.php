<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-13
 * Time: 20:36
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ trans('plugins-product::wish-list.wish_list') }}</a></li>
            </ol>
        </nav>
    </div>
    <section class="mb-5">
        <div class="product-detail">
            <div class="container">
                <div class="text-center">
                    <div class="section-title">{{ trans('plugins-product::wish-list.wish_list') }}</div>
                </div>
                <div class="product-slider">
                    <div class="row product-slider-wrapper">
                        @foreach($wishListProducts as $wishListProduct)
                            <div class="col-md-3">
                                @component("components.product-item")
                                    @slot("productItem", $wishListProduct->product)
                                    @slot("productWishListIds", $productWishListIds)
                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('variable-scripts')

@stop