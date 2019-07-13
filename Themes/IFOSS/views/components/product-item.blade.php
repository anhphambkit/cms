<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-02
 * Time: 07:54
 */
$productItem = !empty($productItem) ? $productItem : collect([]);
$defaultSelectedAttributeValues = [];
if ($productItem->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_CHILD_VARIANT) {
    $customAttributes = $productItem->productCustomAttributes()->get();
    $attributeValues = $productItem->productStringValueAttribute()->get()->groupBy('custom_attribute_id');
}
else {
    $parentVariantProduct = $productItem->parentVariantProduct()->first();
    $customAttributes = $parentVariantProduct->productCustomAttributes()->get();
    $attributeValues = $parentVariantProduct->productStringValueAttribute()->get()->groupBy('custom_attribute_id');
    $defaultSelectedAttributeValues = $productItem->productStringValueAttribute()->get()->groupBy('custom_attribute_id');
}
?>
<div class="product-item product-detail-item product-item-{{ $productItem->id }} product-detail-item-{{ $productItem->id }}" data-product-id="{{ $productItem->id }}">
    <div class="item mb-3">
        @if($productItem->is_has_sale)
            <div class="badge-sale">Sale</div>
        @endif
        <div class="thumbnail mb-0">
            <div class="content">
                <img src="{{ asset($productItem->image_feature) }}">
            </div>
            <div class="mask">
                <div class="content-bottom">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-icon mr-2 btn-show-quick-shop-modal" data-product-id="{{ $productItem->id }}"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="Quick Shop"></i></button>
                        @if($productItem->has_look_book)
                            <a href="{{ route('public.design-ideal.product_design_idea', [ 'url' => $productItem->url_product ]) }}" class="btn btn-icon">
                                <i class="fas fa-lightbulb" data-toggle="tooltip" data-placement="right" title="View in Design Ideas"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if($productItem->available_3d)
            <div class="badge-3d-custom"><img src="{{ asset('themes/ifoss/assets/images/icons/3d.png') }}" alt="" class="img-fluid"></div>
        @endif

        <div class="mask-specs">
                <div class="product-specs mb-0">
                    <div class="title">
                        <a href="{{ route('public.product.detail', [ 'url' => $productItem->url_product ]) }}" class="link-product-detail">{{ $productItem->name }}</a>
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
                </div>
                @component("components.product-attribute-hover-item")
                    @slot("productAttributeValues", $attributeValues)
                    @slot("productAttributes", $customAttributes)
                    @slot("productDefaultAttributeValues", $defaultSelectedAttributeValues)
                    @slot("typeProduct", $productItem->type_product)
                @endcomponent
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex justify-content-between product-quantity-section pt-1">
                            <div class="mr-4">
                                <span class="d-inline-block gray-color" style="width: 120px;">Select Quantity</span>
                                <span class="font-weight-600 quantity-product" data-quantity="1">1</span>
                            </div>
                            <div>
                                <a href="javascript:void(0);" data-action="minus" class="minus-quantity quantity-action action-icon"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/minus-circle.png') }}" alt=""></a>
                                <a href="javascript:void(0);" data-action="plus" class="plus-quantity quantity-action action-icon"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/plus-circle.png') }}" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            <hr class="my-2">
            <div class="d-flex align-items-center">
                <button class="btn btn-custom btn-sm btn-block justify-content-center {{ ($productItem->type_product === \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT) ? 'disabled' : 'add-to-cart-btn' }}"
                    data-toggle="tooltip" data-placement="top"
                    title="{{ ($productItem->type_product === \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT) ? 'Please select full product attribute!' : '' }}">Add to Bag</button>

                <a href="javascript:void(0);" class="wishlist ml-2 add-to-wish-list" data-entity-id="{{ $productItem->id }}" data-type-entity="{{ \Plugins\Product\Contracts\ProductReferenceConfig::ENTITY_TYPE_PRODUCT }}">
                    <i class="{{ ($productItem->was_added_wish_list) ? 'fas' : 'far' }} fa-heart icon-wish-list"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="product-specs">
        <div class="title">
            <a href="{{ route('public.product.detail', [ 'url' => $productItem->url_product ]) }}" class="link-product-detail">{{ $productItem->name }}</a>
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
    </div>
</div>

