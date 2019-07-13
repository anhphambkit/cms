<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-07-12
 * Time: 22:14
 */
?>
<div class="product-item product-detail-item product-item-@{{ product.id }} product-detail-item-@{{ product.id }}" data-product-id="@{{ product.id }}">
    <div class="item mb-3">
        @{{#if product.is_has_sale }}
            <div class="badge-sale">Sale</div>
        @{{/if}}
        <div class="thumbnail mb-0">
            <div class="content">
                <img src="@{{ product.image_feature }}">
            </div>
            <div class="mask">
                <div class="content-bottom">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-icon mr-2 btn-show-quick-shop-modal" data-product-id="@{{ product.id }}"><i class="fas fa-eye" data-toggle="tooltip" data-placement="top" title="Quick Shop"></i></button>
                        @{{#if product.has_look_book }}
                            <a href="@{{ getUrlLink '/design-ideal/product' product.url_product }}" class="btn btn-icon">
                                <i class="fas fa-lightbulb" data-toggle="tooltip" data-placement="right" title="View in Design Ideas"></i>
                            </a>
                        @{{/if}}
                    </div>
                </div>
            </div>
        </div>
        @{{#if product.available_3d }}
            <div class="badge-3d-custom">
                <img src="{{ asset('themes/ifoss/assets/images/icons/3d.png') }}" alt="" class="img-fluid">
            </div>
        @{{/if}}

        <div class="mask-specs">
            <div class="product-specs mb-0">
                <div class="title">
                    <a href="@{{ getUrlLink '/product/detail' product.url_product }}" class="link-product-detail">@{{ product.name }}</a>
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
                    @{{#ifNotEquals product.type_product "variants"}}
                        <div class="main">@{{#if product.is_has_sale }} $@{{ formatCurrency product.sale_price }} @{{else}} $@{{ formatCurrency product.price }} @{{/if}}</div>
                    @{{#if product.is_has_sale }}
                        <div class="discount">$@{{ formatCurrency product.price }}</div>
                        <div class="sale">@{{ formatCurrency product.percent_sale }}% off</div>
                    @{{/if}}
                    @{{else}}
                        <div class="main">$@{{ formatCurrency product.min_price }} - $@{{ formatCurrency product.max_price }}</div>
                    @{{/ifNotEquals}}
                </div>
            </div>
            <div class="product-attributes">
                @{{#each product_attributes }}
                    @{{#if @first}}
                        <hr class="my-2">
                    @{{/if}}
                    <div class="product-attribute @{{#if (isVariantProduct @root.product.type_product) }} variant-attribute @{{/if}} product-attribute-@{{ id }}" data-attribute-type="@{{ type_render }}" data-product-attribute="@{{ id }}"
                         data-is-variant-attribute="@{{ isVariantProduct @root.product.type_product }}"
                         data-attribute-selected-id="@{{ valueByKeyObject @root.product_default_attribute_values id 'id' }}">
                    @{{#ifEquals type_render "color_picker"}}
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex mb-2">
                                <div class="gray-color"  style="width: 120px;">Select @{{ name }}</div>
                                <div class="font-weight-600 attribute-selected-title"
                                     data-attribute-selected-id="@{{#if (productDefaultValue @root.product_default_attribute_values id) }} @{{ productDefaultValue.id }} @{{/if}}"
                                     data-title="@{{#if (productDefaultValue @root.product_default_attribute_values id) }} @{{ productDefaultValue.name }} @{{/if}}">
                                    @{{ valueByKeyObject @root.product_default_attribute_values id 'name' }}
                                </div>
                            </div>
                            <div class="product-specs mb-0">
                                <div class="choose-color">
                                    <div class="d-flex mb-3">
                                        <div class="color-box">
                                            @{{#each (lookup @root.product_attribute_values id) }}
                                                <a href="javascript:void(0);" data-color="@{{ name }}" data-attribute-value-name="@{{ name }}" data-attribute-value-id="@{{ id }}"
                                                   class="mb-0 item item-color-attribute item-product-attribute
                                                                        @{{#ifEquals (valueByKeyObject @root.product_default_attribute_values id 'id') id}}
                                                                            active
                                                                        @{{/ifEquals}}">
                                                    @{{#if image_feature }}
                                                        <img src="@{{ image_feature }}" alt="@{{ name }}">
                                                    @{{else}}
                                                    <span class="product-color-attribute-preview">
                                                        <span class="product-color-attribute-square-box" style="background-color: @{{ value }};"></span>
                                                    </span>
                                                    @{{/if}}
                                                </a>
                                            @{{/each}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @{{/ifEquals}}

                    @{{#ifEquals type_render "string"}}
                    <div class="row mb-3">
                        <div class="col-12" style="border-right: 1px solid #dedede;">
                            <div class="dropdown dropdown-s1">
                                <span>Select @{{ name }}</span>
                                <a href="javascript:void(0);" class=" d-flex justify-content-between align-items-center action-icon font-weight-600" style="height: 25px; color: inherit;" data-toggle="dropdown">
                                    @{{#each (lookup @root.product_attribute_values id) }}
                                        @{{#ifEquals (valueByKeyObject @root.product_default_attribute_values ../id 'id') id}}
                                                <span class="font-weight-600 attribute-selected-title" data-attribute-value-id="@{{ id }}">@{{  name }}</span>
                                        @{{/ifEquals}}
                                    @{{/each}}
                                    <i class="fas fa-chevron-down ml-1"></i>
                                </a>
                                <div class="dropdown-menu align-left" aria-labelledby="account-dropdown">
                                    @{{#each (lookup @root.product_attribute_values id) }}
                                    <a class="dropdown-item item-product-attribute" href="javascript:void(0);"
                                       data-attribute-value-name="@{{ name }}" data-attribute-value-id="@{{ id }}">
                                        @{{ name }}
                                    </a>
                                    @{{/each}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @{{/ifEquals}}
                </div>
                    @{{#if @last}}
                        <hr class="my-2">
                    @{{/if}}
                @{{/each}}
            </div>

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
                <button class="btn btn-custom btn-sm btn-block justify-content-center @{{#ifEquals product.type_product 'variants'}} disabled @{{else}} add-to-cart-btn @{{/ifEquals}}"
                        data-toggle="tooltip" data-placement="top"
                        title="@{{#ifEquals product.type_product 'variants'}} Please select full product attribute! @{{else}} Add to bag @{{/ifEquals}}">Add to Bag</button>
                <a href="javascript:void(0);" class="wishlist ml-2 add-to-wish-list" data-entity-id="@{{ product.id }}" data-type-entity="{{ \Plugins\Product\Contracts\ProductReferenceConfig::ENTITY_TYPE_PRODUCT }}">
                    <i class="@{{#if product.was_added_wish_list }} fas @{{else}} far @{{/if}} fa-heart icon-wish-list"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="product-specs">
        <div class="title">
            <a href="@{{ getUrlLink '/product/detail' product.url_product }}" class="link-product-detail">@{{ product.name }}</a>
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
            @{{#ifNotEquals product.type_product "variants"}}
            <div class="main">@{{#if product.is_has_sale }} $@{{ formatCurrency product.sale_price }} @{{else}} $@{{ formatCurrency product.price }} @{{/if}}</div>
            @{{#if product.is_has_sale }}
            <div class="discount">$@{{ formatCurrency product.price }}</div>
            <div class="sale">@{{ formatCurrency product.percent_sale }}% off</div>
            @{{/if}}
            @{{else}}
            <div class="main">$@{{ formatCurrency product.min_price }} - $@{{ formatCurrency product.max_price }}</div>
            @{{/ifNotEquals}}
        </div>
    </div>
</div>
