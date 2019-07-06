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
        @if($productItem->is_has_sale)
            <div class="badge-sale">Sale</div>
        @endif
        <div class="thumbnail mb-0">
            <div class="content">
                <img src="{{ asset($productItem->image_feature) }}">
            </div>
            <div class="mask">
                <div class="text-center">
                    <button class="btn btn-outline-custom background-white mb-3 btn-show-quick-shop-modal" data-product-id="{{ $productItem->id }}">quick shop</button>
                    @php
                    @endphp
                    @if($productItem->has_look_book)
                        <a href="{{ route('public.design-ideal.product_design_idea', [ 'url' => $productItem->url_product ]) }}">
                            <button class="btn btn-outline-custom background-white">View in Design Ideas</button>
                        </a>
                    @endif
                </div>
                <a href="javascript:void(0);" class="add-to-wish-list favourite text-custom" data-product-id="{{ $productItem->id }}">
                    <i class="{{ ($productItem->was_added_wish_list) ? 'fas' : 'far' }} fa-heart icon-wish-list"></i>
                </a>
            </div>
        </div>
        @if($productItem->available_3d)
            <div class="badge-3d-custom"><img src="{{ asset('themes/ifoss/assets/images/icons/3d.png') }}" alt="" class="img-fluid"></div>
        @endif
    </div>
    <div class="product-specs">
        <div class="title">
            <a href="{{ route('public.product.detail', [ 'url' => $productItem->url_product ]) }}" class="link-product-detail">{{ $productItem->name }}</a>
        </div>
        <div class="price">
            @if($productItem->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                <div class="main">${{ ($productItem->is_has_sale ? number_format($productItem->sale_price) : number_format($productItem->price)) }}</div>
                @if($productItem->is_has_sale)
                    <div class="discount">${{ number_format($productItem->price) }}</div>
                    <div class="sale">{{ number_format($productItem->percent_sale) }}% off</div>
                @endif
            @else
                <div class="main">${{ number_format($productItem->min_price) }} - ${{ number_format($productItem->max_price) }}</div>
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