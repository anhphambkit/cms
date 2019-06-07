<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-07
 * Time: 15:31
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">{{ $categoryPageInfo['category']->name }}</a></li>
            </ol>
        </nav>
    </div>
    <section class="mb-5">
        <div class="product-detail">
            <div class="container">
                <div class="text-center">
                    <div class="section-title">Sale</div>
                </div>
                <div class="product-slider">
                    <div class="row product-slider-wrapper">
                        @foreach($categoryPageInfo['sale_products'] as $saleProduct)
                        <div class="col-md-3">
                            @component("components.product-item")
                                @slot("productItem", $saleProduct)
                            @endcomponent
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @foreach($categoryPageInfo['sub_categories'] as $subCategory)
        <section class="mb-5">
            <div class="product-detail">
                <div class="container">
                    <div class="text-center">
                        <div class="section-title">{{ $subCategory->name }}</div>
                        <div class="clearfix"></div>
                        <a href="#" class="btn-with-hr mt-0 mb-2">Show all</a>
                    </div>
                    <div class="product-slider">
                        <div class="row product-slider-wrapper">
                            @foreach($subCategory->products->slice(0, 8) as $subCategoryProduct)
                            <div class="col-md-3">
                                @component("components.product-item")
                                    @slot("productItem", $subCategoryProduct)
                                @endcomponent
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@stop
@section('variable-scripts')

@stop