<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-07
 * Time: 23:21
 */
$saleProducts = $categoryPageInfo['sale_products'];
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.category.detail', [ 'url' => $categoryPageInfo['category']->url_product_category ]) }}">{{ $categoryPageInfo['category']->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('public.category.sale.page', [ 'url' => $categoryPageInfo['category']->url_product_category ]) }}">Sales</a>
                </li>
            </ol>
        </nav>
    </div>

    <section class="mb-5">
        <div class="product-detail">
            <div class="container">
                <div class="text-left">
                    <div class="section-title">Sales</div>
                </div>
                <div class="product-filter d-sm-flex justify-content-between align-items-center">
                    <span class="gray-color">{{ sizeof($saleProducts) }} Items</span>
                    <div class="product-filter-content">
                        <div class="gray-color text-uppercase mr-3">Sort</div>
                        <div class="filter-action">
                            <div class="dropdown dropdown-s1">
                                <button class="btn btn-outline-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Alphabet A-Z
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Alphabet Z-A</a>
                                    <a class="dropdown-item" href="#">Price Low-High</a>
                                    <a class="dropdown-item" href="#">Price High-Low</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-s1">
                                <button class="btn btn-outline-custom dropdown-toggle" type="button" id="dropdownMenuButton-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-1">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-slider">
                    <div class="product-slider-wrapper">
                        @foreach($saleProducts as $saleProduct)
                            <div class="px-3 product-item-wrapper">
                                @component("components.product-item")
                                    @slot("productItem", $saleProduct)
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
