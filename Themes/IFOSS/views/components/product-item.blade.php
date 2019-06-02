<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 07:54
 */
$productItem = !empty($productItem) ? $productItem : collect([]);
?>
<div class="product-item">
    <div class="item mb-3">
        <div class="thumbnail mb-0">
            <img src="{{ asset($productItem->image_feature) }}">
            <div class="mask">
                <div class="text-center">
                    <button class="btn btn-outline-custom background-white mb-3">quick shop</button>
                    <button class="btn btn-outline-custom background-white">View in Design Ideas</button>
                </div>
                <a href="#" class="favourite text-custom"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/heart.png') }}" alt="" class="icon-img"></a>
            </div>
        </div>
    </div>
    <div class="product-specs">
        <div class="title">
            <a href="{{ $productItem->url_product }}" class="link-product-detail">{{ $productItem->name }}</a>
        </div>
        <div class="price">
            @if($productItem->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                <div class="main">${{ ($productItem->is_has_sale ? $productItem->sale_price : $productItem->price) }}</div>
                @if($productItem->is_has_sale)
                    <div class="discount">${{ $productItem->price }}</div>
                    <div class="sale">{{ $productItem->percent_sale }}% off</div>
                @endif
            @else
                <div class="main">${{ $productItem->min_price }} - ${{ $productItem->max_price }}</div>
            @endif
        </div>
        <div class="rating">
            <div class="rating-star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star unrate"></i>
            </div>
            <div class="reviews">6,415 reviews</div>
        </div>
    </div>
</div>
