<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-01
 * Time: 17:11
 */
$productAttributeValues = !empty($productAttributeValues) ? $productAttributeValues : collect([]);
$productAttributes = !empty($productAttributes) ? $productAttributes : collect([]);
$productDefaultAttributeValues = !empty($productDefaultAttributeValues) ? $productDefaultAttributeValues : collect([]);
$typeProduct = !empty($typeProduct) ? $typeProduct : \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_SIMPLE;
$isVariantAttribute = ($typeProduct === \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_SIMPLE) ? false : true;
?>
<div class="product-attributes">
    @foreach($productAttributes as $indexProductAttribute => $productAttribute)
        @php
            $productDefaultValue = !empty($productDefaultAttributeValues[$productAttribute->id]) ? $productDefaultAttributeValues[$productAttribute->id]->first() : null;
        @endphp
        <div class="product-attribute {{ ($isVariantAttribute) ? 'variant-attribute' : '' }} product-attribute-{{ $productAttribute->id }}" data-product-attribute="{{ $productAttribute->id }}"
             data-is-variant-attribute="{{ $isVariantAttribute }}" data-attribute-selected-id="{{ (!empty($productDefaultValue)) ? $productDefaultValue->id : '' }}">
            @switch($productAttribute->type_render)
                @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
                    <div class="d-flex mb-3">
                        <div class="gray-color mr-4">Select {{ strtolower($productAttribute->name) }}</div>
                        <div class="font-weight-600 attribute-selected-title"
                             data-attribute-selected-id="{{ (!empty($productDefaultValue)) ? $productDefaultValue->id : '' }}"
                             data-title="{{ (!empty($productDefaultValue)) ? $productDefaultValue->name : '' }}">
                            {{ (!empty($productDefaultValue)) ? $productDefaultValue->name : '' }}
                        </div>
                    </div>
                    <div class="color-box">
                        @foreach($productAttributeValues[$productAttribute->id] as $productAttributeValue)
                            <a href="javascript:void(0);" data-color="{{ $productAttributeValue->name }}" data-attribute-value-id="{{ $productAttributeValue->id }}"
                               class="item item-color-attribute item-product-attribute {{ (!empty($productDefaultValue) && $productDefaultValue->id === $productAttributeValue->id) ? 'active' : '' }}">
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
                    @break;
                @case(str_slug(\Plugins\CustomAttributes\Contracts\CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'))
                    <div class="d-flex justify-content-between">
                        <div class="mr-4">
                            <span class="d-inline-block gray-color" style="width: 120px;">Select {{ strtolower($productAttribute->name) }}</span>
                            @foreach($productAttributeValues[$productAttribute->id] as $productAttributeValue)
                                @if(!empty($productDefaultValue))
                                    <span class="font-weight-600" data-attribute-value-id="{{ $productAttributeValue->id }}">{{  $productAttributeValue->name }}</span>
                                @endif
                            @endforeach
                        </div>
                        <a href="javascript:void(0);" class="action-icon" data-toggle="dropdown"><i class="fas fa-chevron-right"></i></a>
                        <div class="dropdown-menu align-left" aria-labelledby="account-dropdown">
                            @foreach($productAttributeValues[$productAttribute->id] as $productAttributeValue)
                                <a class="dropdown-item" href="#">{{ $productAttributeValue->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @break;
            @endswitch
        </div>
        @if($indexProductAttribute < $productAttributes->count() - 1)
            <hr />
        @endif
    @endforeach
</div>