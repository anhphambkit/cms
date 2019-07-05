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
                @if($cart['products']->isEmpty())
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <div class="section-title">My Cart</div>
                                </div>
                                <div class="empty-cart">
                                    <div class="h5 mb-2">You don't have any product</div>
                                    <a href="{{ route('homepage') }}" class="text-custom d-inline-block"><img src="{{ asset('themes/ifoss/assets/images/icons/arrow-left.png') }}" class="mr-2">Continue Shopping</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
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
                            <div class="mb-4">
                                <div class="font-weight-500 mb-2">My Saved Items ({{ $savedProducts->count() }} Item)</div>
                                <div class="cart-list">
                                    @foreach($savedProducts as $savedProduct)
                                        @component("components.product-item-save-for-later")
                                            @slot("productItem", $savedProduct->product)
                                        @endcomponent
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 cart-info-total" style="margin-top: 66px;">
                            <div class="cart-order-info font-weight-500">
                                <div class="list-item">
                                    Subtotal
                                    <span class="sub-total-cart">${{ number_format($cart['sub_total']) }}</span>
                                </div>
                                <div class="list-item">
                                    Shipping fee
                                    <span>FREE</span>
                                </div>
                                <div class="list-item">
                                    Discount
                                    <span class="discount-price">${{ number_format($cart['coupon_discount_amount']) }}</span>
                                </div>
                                <div class="list-item">
                                    Tax
                                    <span>$0</span>
                                </div>
                                <hr>
                                <div class="list-item">
                                    Total
                                    <span class="font-size-24 total-price-cart">${{ number_format($cart['total_price']) }}</span>
                                </div>
                                <div class="list-item">
                                    Your Save
                                    <span class="saved-price-cart">${{ number_format($cart['saved_price']) }}</span>
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
                                    <span type="text" class="wanting-price rounded-0 px-2 special-price">+  ${{ number_format($cart['free_design']['wanting_price']) }}</span>
                                    <div class="input-group-append">
                                        <span class="input-group-text font-size-12 rounded-0 total-free-designs-cart" style="background-color: rgba(150,196,189,.2); color: #2a7469;">to qualify for {{ $cart['free_design']['total_free_design'] + 1 }} FREE DESIGN</span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="#" class="text-blue text-uppercase text-underline">Learn more</a>
                                </div>
                            </div>
                            <a href="{{ route('public.product.checkout') }}">
                                <button type="button" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">
                                    Checkout
                                </button>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@stop
@section('variable-scripts')
    <script>
        const API = {
            ADD_COUPON_TO_CART : "{{ route('ajax.product.add_coupon') }}",
            DELETE_COUPON_IN_CART : "{{ route('ajax.product.delete_coupon') }}",
            SAVE_PRODUCT_FOR_LATER : "{{ route('ajax.product.save_product_for_later') }}",
            MOVE_PRODUCT_TO_CART : "{{ route('ajax.product.move_product_to_cart') }}",
            DELETE_PRODUCT_SAVED : "{{ route('ajax.product.delete_product_saved') }}",
        };
    </script>
@stop
