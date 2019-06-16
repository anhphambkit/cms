<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-16
 * Time: 09:32
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('public.design-ideal') }}">Design Ideas</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('public.product.detail', [ 'url' => $product->url_product ]) }}">{{ $product->name }}</a>
                </li>
            </ol>
        </nav>
    </div>
    <section class="design-ideas">
        <div class="container-fluid">
            <div class="text-center">
                <div class="section-title-s2">Design ideas of {{ $product->name }}</div>
            </div>
            @include("pages.partials.list-look-book")
            {{--<div class="text-center py-4">--}}
            {{--<a href="javascript:void(0);" class="btn-view-icon"><i class="fas fa-plus"></i> <span>Load more</span></a>--}}
            {{--</div>--}}
        </div>
    </section>
@stop
