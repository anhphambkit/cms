<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-07
 * Time: 23:06
 */
$parentCategory = $categoryPageInfo['category']->parentCategory;
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.category.detail', [ 'url' => $parentCategory->url_product_category ]) }}">{{ $parentCategory->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('public.category.sub_category', [ 'url' => $parentCategory->url_product_category, 'subCategory' => $categoryPageInfo['category']->url_product_category ]) }}">{{ $categoryPageInfo['category']->name }}</a>
                </li>
            </ol>
        </nav>
    </div>

    <section class="mb-5">
        <div class="product-detail">
            <div class="container">
                <div class="text-left">
                    <div class="section-title">{{ $categoryPageInfo['category']->name }}</div>
                </div>
                <div class="product-filter d-sm-flex justify-content-between align-items-center">
                    <span class="gray-color">{{ sizeof($categoryPageInfo['products']) }} Items</span>
                    <div class="product-filter-content">
                        <div class="gray-color text-uppercase mr-3">Sort</div>
                        <div class="filter-action">
                            @include("pages.partials.sort-order-list-page", [ 'currentRoute' => route('public.category.sub_category', [ 'url' => $parentCategory->url_product_category, 'subCategory' => $categoryPageInfo['category']->url_product_category ]) ])
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
                    <div class="row list-products" id="list-products">
                        @foreach($categoryPageInfo['products'] as $categoryProduct)
                            <div class="col-md-3">
                                @component("components.product-item")
                                    @slot("productItem", $categoryProduct)

                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.modals.quick-shop-modal')
@stop
@section('variable-scripts')
    <script id="template-quick-shop-modal" type="text/x-handlebars-template">
        @include('handle-bar.quick-shop-modal')
    </script>
@stop
