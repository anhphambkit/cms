<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 09:49
 */
$productItem = !empty($productItem) ? $productItem : collect([]);
$customAttributes = $productItem->productCustomAttributes()->get();
$attributeValues = $productItem->productStringValueAttribute()->get();
?>
<div class="item row ml-0 mr-0">
    <div class="thumbnail">
        <img src="{{ get_object_image($productItem->image_feature, 'mediumThumb') }}" alt="{{ $productItem->name }}" />
    </div>
    <div class="content">
        <div class="price">
            @if($productItem->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                <div class="font-size-18">${{ ($productItem->is_has_sale ? $productItem->sale_price : $productItem->price) }}</div>
                @if($productItem->is_has_sale)
                    <div class="font-size-12 text-line-through">${{ $productItem->price }}</div>
                @endif
            @else
                <div class="font-size-18">${{ $productItem->min_price }} - ${{ $productItem->max_price }}</div>
            @endif
        </div>
        <div class="title">{{ $productItem->name }}</div>
        @foreach($attributeValues as $attributeValue)
            <div class="mb-1">{{ $customAttributes->where('id', $attributeValue->custom_attribute_id)->first()->name }}: {{ $attributeValue->name }}</div>
        @endforeach
        <div class="d-flex align-items-center">
            Quantity
            <div class="d-inline-block mx-3">{{ $productItem->quantity }}</div>
            <div class="quantity-btn">
                <a class="btn" href="#"><img src="{{ asset('themes/ifoss/assets/images/icons/chervon-top.png') }}" alt=""/></a>
                <a class="btn" href="#"><img src="{{ asset('themes/ifoss/assets/images/icons/chervon-bottom.png') }}" alt=""/></a>
            </div>
        </div>
        <div class="mt-3 text-right">
            <a href="#" class="text-custom mr-4"><img src="{{ asset('themes/ifoss/assets/images/icons/bookmark.png') }}" alt="" width="14" /> Save for later</a>
            <a href="#" class="text-custom"><img src="{{ asset('themes/ifoss/assets/images/icons/trash.png') }}" alt="" width="14" /> Remove</a>
        </div>
    </div>
</div>
