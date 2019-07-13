<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-07-12
 * Time: 19:58
 */
$productAttributeValues = !empty($productAttributeValues) ? $productAttributeValues : collect([]);
$productAttributes = !empty($productAttributes) ? $productAttributes : collect([]);
$productDefaultAttributeValues = !empty($productDefaultAttributeValues) ? $productDefaultAttributeValues : [];
$typeProduct = !empty($typeProduct) ? $typeProduct : \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_SIMPLE;
$isVariantAttribute = ($typeProduct === \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_SIMPLE) ? false : true;
?>
<div class="product-attributes">
@foreach($productAttributes as $indexProductAttribute => $productAttribute)
    @if($indexProductAttribute === 0)
        <hr class="my-2">
    @endif
    @php
        $productDefaultValue = !empty($productDefaultAttributeValues[$productAttribute->id]) ? $productDefaultAttributeValues[$productAttribute->id][0] : null;
    @endphp

    <div class="product-attribute {{ ($isVariantAttribute) ? 'variant-attribute' : '' }} product-attribute-{{ $productAttribute->id }}" data-attribute-type="{{ $productAttribute->type_render }}" data-product-attribute="{{ $productAttribute->id }}"
         data-is-variant-attribute="{{ $isVariantAttribute }}" data-attribute-selected-id="{{ (!empty($productDefaultValue)) ? $productDefaultValue['id'] : '' }}">
        @switch($productAttribute->type_render)
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
            <div class="row">
                <div class="col-12">
                    <div class="d-flex mb-2">
                        <div class="gray-color"  style="width: 120px;">Select {{ strtolower($productAttribute->name) }}</div>
                        <div class="font-weight-600 attribute-selected-title"
                             data-attribute-selected-id="{{ (!empty($productDefaultValue)) ? $productDefaultValue['id'] : '' }}"
                             data-title="{{ (!empty($productDefaultValue)) ? $productDefaultValue->name : '' }}">
                            {{ (!empty($productDefaultValue)) ? $productDefaultValue->name : '' }}
                        </div>
                    </div>
                    <div class="product-specs mb-0">
                        <div class="choose-color">
                            <div class="d-flex mb-3">
                                <div class="color-box">
                                    @foreach($productAttributeValues[$productAttribute->id] as $productAttributeValue)
                                        <a href="javascript:void(0);" data-color="{{ $productAttributeValue->name }}" data-attribute-value-name="{{ $productAttributeValue->name }}" data-attribute-value-id="{{ $productAttributeValue->id }}"
                                           class="item mb-0 item-color-attribute item-product-attribute {{ (!empty($productDefaultValue) && $productDefaultValue['id'] === $productAttributeValue->id) ? 'active' : '' }}">
                                            @if($productAttributeValue->image_feature)
                                                <img src="{{ asset($productAttributeValue->image_feature) }}" alt="{{ $productAttributeValue->name }}">
                                            @else
                                                <span class="product-color-attribute-preview">
                                                            <span class="product-color-attribute-square-box" style="background-color: {{ $productAttributeValue->value }};"></span>
                                                        </span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break;
            @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'))
            <div class="row mb-3">
                <div class="col-12" style="border-right: 1px solid #dedede;">
                    <div class="dropdown dropdown-s1">
                        <span>Select {{ strtolower($productAttribute->name) }}</span>
                        <a href="javascript:void(0);" class=" d-flex justify-content-between align-items-center action-icon font-weight-600" style="height: 25px; color: inherit;" data-toggle="dropdown">
                            @foreach($productAttributeValues[$productAttribute->id] as $productAttributeValue)
                                @if(!empty($productDefaultValue) && $productDefaultValue['id'] === $productAttributeValue->id)
                                    <span class="font-weight-600 attribute-selected-title" data-attribute-value-id="{{ $productAttributeValue->id }}">{{  $productAttributeValue->name }}</span>
                                @endif
                            @endforeach
                            <i class="fas fa-chevron-down ml-1"></i>
                        </a>
                        <div class="dropdown-menu align-left" aria-labelledby="account-dropdown">
                            @foreach($productAttributeValues[$productAttribute->id] as $productAttributeValue)
                                <a class="dropdown-item item-product-attribute" href="javascript:void(0);" data-attribute-value-name="{{ $productAttributeValue->name }}" data-attribute-value-id="{{ $productAttributeValue->id }}">{{ $productAttributeValue->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @break;
        @endswitch
    </div>

    @if($indexProductAttribute === $productAttributes->count() - 1)
        <hr class="my-2">
    @endif
@endforeach
</div>