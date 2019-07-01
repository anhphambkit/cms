<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-29
 * Time: 10:12
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item">
                    {{ $keySearch }}
                </li>
            </ol>
        </nav>
    </div>

    <section class="mb-5">
        <div class="product-detail">
            <div class="container">
                <div class="text-left">
                    <div class="section-title">{{ $keySearch }}</div>
                </div>
                <div class="product-filter d-sm-flex justify-content-between align-items-center">
                    <span class="gray-color">{{ sizeof($products['data']) }} Items</span>
                    <div class="product-filter-content">
                        <div class="gray-color text-uppercase mr-3">Sort</div>
                        <div class="filter-action">
                            @include("pages.partials.sort-order-list-page", [ 'currentRoute' => route('public.product.search', [ 'search' => $keySearch]), 'connectParameterChar' => "&" ])
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
                    <div class="row">
                        @foreach($products['data'] as $productSearch)
                            <div class="col-md-3">
                                @component("components.product-item")
                                    @slot("productItem", $productSearch)

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
