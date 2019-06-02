<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 12:54
 */
$productItem = !empty($productItem) ? $productItem : [];
?>
<div class="item">
    <div class="thumbnail" >
        <img src="{{ asset($productItem['image_feature']) }}">
        <div class="mask">
            <button class="btn btn-white">quick view</button>
            <a href="#" class="favourite"><i class="far fa-heart"></i></a>
        </div>
    </div>
    <div class="title">
        <a href="{{ route('public.product.detail', [ 'url' => $productItem['url_product'] ]) }}" class="link-product-detail">{{ $productItem['name'] }}</a>
    </div>
    <div class="price">

    </div>

    <div class="title">
        <a href="{{ route('public.product.detail', [ 'url' => $productItem['url_product'] ]) }}" class="link-product-detail">{{ asset($productItem['name']) }}</a>
    </div>
    <div class="cost">
        @if($productItem['type_product'] !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
            <div class="original-cost">${{ ($productItem['is_has_sale'] ? $productItem['sale_price'] : $productItem['price']) }}</div>
            @if($productItem['is_has_sale'])
                <div class="discount">${{ $productItem['price'] }}</div>
            @endif
        {{--@else--}}
            {{--<div class="original-cost">${{ $productItem['min_price }} - ${{ $productItem['max_price'] }}</div>--}}
        @endif
    </div>
</div>
