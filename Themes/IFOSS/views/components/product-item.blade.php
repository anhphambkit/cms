<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 07:54
 */
$productItem = !empty($productItem) ? $productItem : collect([]);
$productWishListIds = !empty($productWishListIds) ? $productWishListIds : [];
?>
<div class="product-item">
    <div class="item mb-3">
        @if($productItem->is_has_sale)
            <div class="badge-sale">Sale</div>
        @endif
        @if($productItem->available_3d)
                {{--<div class="badge-3d"><img src="{{ asset('themes/ifoss/assets/images/icons/3d.png') }}" alt="" class="img-fluid"></div>--}}
        @endif
        <div class="thumbnail mb-0">
            <div class="content">
                <img src="{{ asset($productItem->image_feature) }}">
            </div>
            <div class="mask">
                <div class="text-center">
                    <button class="btn btn-outline-custom background-white mb-3">quick shop</button>
                    @php
                    @endphp
                    @if($productItem->available_3d)
                        <button class="btn btn-outline-custom background-white">View in Design Ideas</button>
                    @endif
                </div>
                <a href="javascript:void(0);" class="add-to-wish-list favourite text-custom" data-product-id="{{ $productItem->id }}">
                    <i class="{{ in_array($productItem->id, $productWishListIds) ? 'fas' : 'far' }} fa-heart icon-wish-list"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="product-specs">
        <div class="title">
            <a href="{{ route('public.product.detail', [ 'url' => $productItem->url_product ]) }}" class="link-product-detail">{{ $productItem->name }}</a>
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