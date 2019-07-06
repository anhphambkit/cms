<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 09:49
 */
$productItem = !empty($productItem) ? $productItem : collect([]);
$quantities = !empty($quantities) ? $quantities : [];
$customAttributes = $productItem->productCustomAttributes()->get();
$attributeValues = $productItem->productStringValueAttribute()->get();
?>
<div class="item row ml-0 mr-0 row-product row-product-{{ $productItem->id }}" data-product-id="{{ $productItem->id }}">
    <div class="thumbnail">
        <img src="{{ get_object_image($productItem->image_feature, 'mediumThumb') }}" alt="{{ $productItem->name }}" />
    </div>
    <div class="content">
        <div class="price">
            @if($productItem->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                <div class="font-size-18">${{ ($productItem->is_has_sale ? number_format($productItem->sale_price) : number_format($productItem->price)) }}</div>
                @if($productItem->is_has_sale)
                    <div class="font-size-12 text-line-through">${{ number_format($productItem->price) }}</div>
                @endif
            @else
                <div class="font-size-18">${{ number_format($productItem->min_price) }} - ${{ number_format($productItem->max_price) }}</div>
            @endif
        </div>
        <div class="title">
            <a href="{{ route('public.product.detail', [ 'url' => $productItem->url_product ]) }}" class="link-product-detail">{{ $productItem->name }}</a>
        </div>
        @foreach($attributeValues as $attributeValue)
            <div class="mb-1">{{ $customAttributes->where('id', $attributeValue->custom_attribute_id)->first()->name }}: {{ $attributeValue->name }}</div>
        @endforeach
        <div class="d-flex align-items-center quantity-product-item">
            Quantity
            <div class="d-inline-block mx-3">
                <input type="text" size="9999" min="1" class="quantity-product-item-input" value="{{ $quantities[$productItem->id] }}" />
            </div>
            <div class="quantity-btn">
                <a class="btn btn-plus-quantity-item" href="javascript:void(0);"><img src="{{ asset('themes/ifoss/assets/images/icons/chervon-top.png') }}" alt=""/></a>
                <a class="btn btn-minus-quantity-item" href="javascript:void(0);"><img src="{{ asset('themes/ifoss/assets/images/icons/chervon-bottom.png') }}" alt=""/></a>
            </div>
        </div>
        <div class="mt-3 text-right">
            <a href="javascript:void(0);" class="text-custom mr-4 btn-save-product-later"><img src="{{ asset('themes/ifoss/assets/images/icons/bookmark.png') }}" alt="" width="14" /> Save for later</a>
            <a href="javascript:void(0);" class="text-custom btn-remove-product-in-cart"><img src="{{ asset('themes/ifoss/assets/images/icons/trash.png') }}" alt="" width="14" /> Remove</a>
        </div>
    </div>
</div>
