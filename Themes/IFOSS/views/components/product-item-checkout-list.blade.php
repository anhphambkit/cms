<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 12:13
 */
$productItem = !empty($productItem) ? $productItem : collect([]);
$quantities = !empty($quantities) ? $quantities : [];
$customAttributes = $productItem->productCustomAttributes()->get();
$attributeValues = $productItem->productStringValueAttribute()->get();
?>
<div class="list-item">
    <div class="thumbnail">
        <img src="{{ URL::asset('themes/ifoss/assets/images/products/product-cart-1.jpg') }}" alt=""/>
    </div>
    <div>
        <div class="mb-1"><a href="{{ route('public.product.detail', [ 'url' => $productItem->url_product ]) }}">{{ $productItem->name }}</a></div>
        <div class="font-size-12" style="color: #7f7f7f;">
            @foreach($attributeValues as $attributeValue)
                <div>{{ $customAttributes->where('id', $attributeValue->custom_attribute_id)->first()->name }}: {{ $attributeValue->name }}</div>
            @endforeach
            <div>Quantity:  {{ $quantities[$productItem->id] }}</div>
        </div>
    </div>
</div>
