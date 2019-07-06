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
                    <div class="section-title">{{ trans('plugins-product::product.name') }}</div>
                </div>
                <div class="product-slider">
                    <div class="row list-products" id="list-products">
                        @foreach($wishListEntities[\Plugins\Product\Contracts\ProductReferenceConfig::ENTITY_TYPE_PRODUCT] as $wishListProduct)
                            <div class="px-3 product-item-wrapper">
                                @component("components.product-item")
                                    @slot("productItem", $wishListProduct)
                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--<section class="mb-5">--}}
        {{--<div class="product-detail">--}}
            {{--<div class="container">--}}
                {{--<div class="text-center">--}}
                    {{--<div class="section-title">{{ trans('plugins-product::look-book.name') }}</div>--}}
                {{--</div>--}}
                {{--<div class="product-slider">--}}
                    {{--<div class="row list-look-books" id="list-look-books">--}}
                        {{--@foreach($wishListEntities[\Plugins\Product\Contracts\ProductReferenceConfig::ENTITY_TYPE_LOOK_BOOK] as $wishListLookBook)--}}
                            {{--<div class="px-3 product-item-wrapper">--}}
                                {{--@component("components.look-book-item")--}}
                                    {{--@slot('typeLookBook', $wishListLookBook->type_layout)--}}
                                    {{--@slot('urlImage', $wishListLookBook->image)--}}
                                    {{--@slot('nameLookBook', $wishListLookBook->name)--}}
                                    {{--@slot('urlLookBook', $wishListLookBook->slug_link)--}}
                                {{--@endcomponent--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    @include('partials.modals.quick-shop-modal')
@stop
@section('variable-scripts')
    <script id="template-quick-shop-modal" type="text/x-handlebars-template">
        @include('handle-bar.quick-shop-modal')
    </script>
@stop