<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 08:56
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Cart</li>
            </ol>
        </nav>
    </div>
    <section class="mb-5">
        <div class="product-cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <div class="section-title">My Cart</div>
                                <a href="{{ route('homepage') }}" class="text-custom d-inline-block"><img src="{{ asset('themes/ifoss/assets/images/icons/arrow-left.png') }}" class="mr-2">Continue Shopping</a>
                            </div>
                            <div class="cart-list">
                                @foreach($cart['products'] as $productCartItem)
                                    @component("components.product-item-horizontal")
                                        @slot("productItem", $productCartItem)
                                        @slot("quantities", $cart['quantities'])
                                    @endcomponent
                                @endforeach
                            </div>
                        </div>
                        {{--<div class="mb-4">--}}
                            {{--<div class="font-weight-500 mb-2">My Saved Items (1 Item)</div>--}}
                            {{--<div class="cart-list">--}}
                                {{--<div class="item row ml-0 mr-0">--}}
                                    {{--<div class="thumbnail">--}}
                                        {{--<img src="{{ asset('themes/ifoss/assets/images/products/product-cart-1.jpg') }}" alt="">--}}
                                    {{--</div>--}}
                                    {{--<div class="content">--}}
                                        {{--<div class="price">--}}
                                            {{--<div class="font-size-18">$6282</div>--}}
                                            {{--<div class="font-size-12 text-line-through">$102.05</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="title">Orthopedic Double Pet Pillow</div>--}}
                                        {{--<div class="mb-1">Color: Red</div>--}}
                                        {{--<div class="mb-1">Size: Medium (34" L x 24" W)</div>--}}
                                        {{--<div class="d-flex align-items-center">--}}
                                            {{--Quantity--}}
                                            {{--<div class="d-inline-block mx-3">1</div>--}}
                                            {{--<div class="quantity-btn">--}}
                                                {{--<a class="btn" href="#"><img src="{{ asset('themes/ifoss/assets/images/icons/chervon-top.png') }}" alt=""/></a>--}}
                                                {{--<a class="btn" href="#"><img src="{{ asset('themes/ifoss/assets/images/icons/chervon-bottom.png') }}" alt=""/></a>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="mt-3 text-right">--}}
                                            {{--<a href="#" class="text-custom mr-4"><img src="{{ asset('themes/ifoss/assets/images/icons/bookmark.png') }}" alt="" width="14" /> Save for later</a>--}}
                                            {{--<a href="#" class="text-custom"><img src="{{ asset('themes/ifoss/assets/images/icons/trash.png') }}" alt="" width="14" /> Remove</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div class="col-lg-4 cart-info-total" style="margin-top: 66px;">
                        <div class="cart-order-info font-weight-500">
                            <div class="list-item">
                                Subtotal
                                <span class="sub-total-cart">${{ $cart['total_price'] }}</span>
                            </div>
                            <div class="list-item">
                                Shipping fee
                                <span>FREE</span>
                            </div>
                            <div class="list-item">
                                Tax
                                <span>$0</span>
                            </div>
                            <hr>
                            <div class="list-item">
                                Total
                                <span class="font-size-24 total-price-cart">${{ $cart['total_price'] }}</span>
                            </div>
                            <div class="list-item">
                                Your Save
                                <span class="saved-price-cart">${{ $cart['saved_price'] }}</span>
                            </div>
                        </div>

                        <div class="cart-order-info font-weight-500 mb-0">
                            <div class="text-uppercase mb-2">Coupon DISCOUNT</div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control rounded-0" placeholder="Enter your code here" id="coupon_code" name="coupon_code">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary rounded-0 add-coupon-btn" id="add-coupon-btn" type="button">apply</button>
                                </div>
                            </div>
                            <div class="coupon-in-use">
                                @if($cart['coupon'])
                                    <div class="row coupon-{{ $cart['coupon']->id }}">
                                       <div class="text-uppercase mb-2 col-md-8 coupon-code-text">{{ $cart['coupon']->code }}</div>
                                       <div class="text-uppercase mb-2 col-md-4">
                                           <a class="action-delete-coupon delete-coupon-{{ $cart['coupon']->id }}" data-coupon-id="{{ $cart['coupon']->id }}">
                                               <i class="far fa-trash-alt icon-action-delete-coupon"></i>
                                               {{ trans('core-base::forms.delete') }}
                                           </a>
                                       </div>
                                   </div>
                                @endif
                            </div>
                        </div>
                        <div class="coupon-calc">
                            <div class="font-weight-500 mb-2">We offer free design for qualifying order over ${{ config('plugins-product.product.price_get_free_design_idea') }}</div>
                            <div class="input-group mb-3" style="box-shadow: 0 4px 12px #d6e9e7;">
                                <span type="text" class="wanting-price rounded-0 px-2 special-price">+  ${{ $cart['free_design']['wanting_price'] }}</span>
                                <div class="input-group-append">
                                    <span class="input-group-text font-size-12 rounded-0 total-free-designs-cart" style="background-color: rgba(150,196,189,.2); color: #2a7469;">to qualify for {{ $cart['free_design']['total_free_design'] + 1 }} FREE DESIGN</span>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="#" class="text-blue text-uppercase text-underline">Learn more</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">
                            <a href="{{ route('public.product.checkout') }}">Checkout</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('variable-scripts')
    <script>
        const API = {
            ADD_COUPON_TO_CART : "{{ route('ajax.product.add_coupon') }}",
            DELETE_COUPON_IN_CART : "{{ route('ajax.product.delete_coupon') }}",
        };
    </script>
@stop
