<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-07-02
 * Time: 03:44
 */
?>
<div class="modal-header border-0">
    <h5 class="modal-title text-uppercase text-custom" id="exampleModalLabel">@{{ product.name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><img src="{{ asset('themes/ifoss/assets/images/icons/close.png') }}" alt=""></span>
    </button>
</div>
<div class="modal-body">
    <div class="container-fluid">
        <div class="product-detail" data-product-id="@{{ product.id }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 product-detail-wrapper">
                        <div class="product-gallery mb-5" style="background-color: #fff;">
                            <div class="gallery-small">
                                <div class="slider-nav">
                                    @{{#each product.galleries }}
                                        <a href="javascript:void(0);" class="item"><img src="@{{ media }}" alt="@{{ media }}"></a>
                                    @{{/each}}
                                </div>
                            </div>
                            <div class="gallery-detail">
                                @{{#if product.is_has_sale }}
                                    <div class="badge-sale">Sale</div>
                                @{{/if}}
                                <div class="slider-for">
                                    @{{#each product.galleries }}
                                        <div class="item"><img src="@{{ media }}" alt="@{{ media }}"></div>
                                    @{{/each}}
                                </div>
                                @{{#if product.available_3d }}
                                    <div class="text-right">
                                        <a href="#" class="btn-link-custom">View in Design Ideas</a>
                                    </div>
                                @{{/if}}
                            </div>
                        </div>
                        <div class="product-information">
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-detail-description"><span>Description</span> <i class="icon fas fa-plus"></i></div>
                                <div class="content" id="panel-detail-description">
                                    @{{{ product.long_desc }}}
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-weight-dimension-description"><span>Weights & Dimensions</span> <i class="icon fas fa-plus"></i></div>
                                <div class="content" id="panel-weight-dimension-description">
                                    @{{{ product.weight_dimension_description }}}
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-toggle-specifications"><span>Specifications</span> <i class="icon fas fa-plus"></i></div>
                                <div class="collapse" id="panel-toggle-specifications">
                                    @{{{ product.specification }}}
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-toggle-shipping-returns"><span>Shipping & Returns</span> <i class="icon fas fa-plus"></i></div>
                                <div class="collapse" id="panel-toggle-shipping-returns">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nisi justo, porttitor nec tristique venenatis, laoreet nec velit. Suspendisse eu elit scelerisque justo scelerisque faucibus. Vivamus accumsan iaculis tortor a consectetur. Duis ornare semper velit id finibus. Phasellus in feugiat metus. Fusce iaculis turpis efficitur luctus vulputate. Nam nec tempus erat, eu blandit ipsum. Sed at luctus turpis. Donec porta, metus ac varius cursus, urna quam pharetra odio, ut consequat nunc orci vel dolor. Fusce porttitor dolor a ligula vestibulum, eget consectetur ipsum viverra. In dui nulla, volutpat et sapien non, aliquam vulputate lacus. Mauris laoreet sapien et urna luctus dapibus. Nulla massa velit, faucibus sit amet malesuada nec, dapibus rhoncus quam.
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-toggle-reviews"><span>Reviews</span> <i class="icon fas fa-plus"></i></div>
                                <div class="collapse" id="panel-toggle-reviews">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nisi justo, porttitor nec tristique venenatis, laoreet nec velit. Suspendisse eu elit scelerisque justo scelerisque faucibus. Vivamus accumsan iaculis tortor a consectetur. Duis ornare semper velit id finibus. Phasellus in feugiat metus. Fusce iaculis turpis efficitur luctus vulputate. Nam nec tempus erat, eu blandit ipsum. Sed at luctus turpis. Donec porta, metus ac varius cursus, urna quam pharetra odio, ut consequat nunc orci vel dolor. Fusce porttitor dolor a ligula vestibulum, eget consectetur ipsum viverra. In dui nulla, volutpat et sapien non, aliquam vulputate lacus. Mauris laoreet sapien et urna luctus dapibus. Nulla massa velit, faucibus sit amet malesuada nec, dapibus rhoncus quam.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product-sidebar">
                            <div class="product-specs">
                                <div class="sku">SKU:  @{{ product.sku }}</div>
                                <div class="title">@{{ product.name }}</div>
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
                                <div class="price current-selected-product">
                                    @{{#ifNotEquals product.type_product "variants"}}
                                        <div class="main">$@{{#if product.is_has_sale }} @{{ product.sale_price }} @{{else}} @{{ product.price }} @{{/if}}</div>
                                        @{{#if product.is_has_sale }}
                                            <div class="discount">$@{{ product.price }}</div>
                                            <div class="sale">@{{ product.percent_sale }}% off</div>
                                        @{{/if}}
                                    @{{else}}
                                        <div class="main">$@{{ product.min_price }} - $@{{ product.max_price }}</div>
                                    @{{/ifNotEquals}}
                                </div>
                                <div class="feature-items">
                                    <div class="item"><img src="{{ asset('themes/ifoss/assets/images/icons/truck.png') }}" alt="" class="icon"> Free Shipping</div>
                                </div>
                                <div class="choose-color">
                                    <div class="product-attributes">
                                        @{{#each product_attributes }}
                                            <div class="product-attribute @{{#if (isVariantProduct @root.product.type_product) }} variant-attribute @{{/if}} product-attribute-@{{ id }}" data-attribute-type="@{{ type_render }}" data-product-attribute="@{{ id }}"
                                                 data-is-variant-attribute="@{{ isVariantProduct @root.product.type_product }}"
                                                 data-attribute-selected-id="@{{ valueByKeyObject @root.product_default_attribute_values id 'id' }}">
                                                @{{#ifEquals type_render "color_picker"}}
                                                    <div class="d-flex mb-3">
                                                        <div class="gray-color mr-4">Select @{{ name }}</div>
                                                        <div class="font-weight-600 attribute-selected-title"
                                                             data-attribute-selected-id="@{{#if (productDefaultValue @root.product_default_attribute_values id) }} @{{ productDefaultValue.id }} @{{/if}}"
                                                             data-title="@{{#if (productDefaultValue @root.product_default_attribute_values id) }} @{{ productDefaultValue.name }} @{{/if}}">
                                                                @{{ valueByKeyObject @root.product_default_attribute_values id 'name' }}
                                                        </div>
                                                    </div>
                                                    <div class="color-box">
                                                        @{{#each (lookup @root.product_attribute_values id) }}
                                                            <a href="javascript:void(0);" data-attribute-value-name="@{{ name }}" data-attribute-value-id="@{{ id }}"
                                                               class="item item-color-attribute item-product-attribute
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
                                                @{{/ifEquals}}
                                                @{{#ifEquals type_render "string"}}
                                                    <div class="d-flex justify-content-between">
                                                        <div class="mr-4">
                                                            <span class="d-inline-block gray-color" style="width: 120px;">Select @{{ name }}</span>
                                                            @{{#each (lookup @root.product_attribute_values id) }}
                                                                @{{#ifEquals (valueByKeyObject @root.product_default_attribute_values ../id 'id') id}}
                                                                    <span class="font-weight-600" data-attribute-value-id="@{{ id }}">@{{  name }}</span>
                                                                @{{/ifEquals}}
                                                            @{{/each}}
                                                        </div>
                                                        <div class="dropdown dropdown-s1">
                                                            <a href="javascript:void(0);" class="action-icon" data-toggle="dropdown"><i class="fas fa-chevron-right"></i></a>
                                                            <div class="dropdown-menu align-left" aria-labelledby="account-dropdown">
                                                                @{{#each (lookup @root.product_attribute_values id) }}
                                                                <a class="dropdown-item item-product-attribute" href="javascript:void(0);" data-attribute-value-name="@{{ name }}" data-attribute-value-id="@{{ id }}">@{{ name }}</a>
                                                                @{{/each}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @{{/ifEquals}}
                                            </div>
                                            <hr>
                                        @{{/each}}
                                    </div>
                                    <div class="d-flex justify-content-between product-quantity-section">
                                        <div class="mr-4">
                                            <span class="d-inline-block gray-color" style="width: 120px;">Select Quantity</span>
                                            <span class="font-weight-600 quantity-product" data-quantity="1">1</span>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" data-action="minus" class="minus-quantity quantity-action action-icon"><img src="{{ asset('themes/ifoss/assets/images/icons/minus-circle.png') }}" alt=""></a>
                                            <a href="javascript:void(0);" data-action="plus" class="plus-quantity quantity-action action-icon"><img src="{{ asset('themes/ifoss/assets/images/icons/plus-circle.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-outline-custom mr-2 add-to-wish-list" data-product-id="@{{ product.id }}"><i class="@{{#if product.was_added_wish_list }} fas @{{else}} far @{{/if}} fa-heart mr-2 icon-wish-list"></i> Wishlist</button>
                                    <button class="btn btn-custom btn-block justify-content-center @{{#ifEquals product.type_product 'variants'}} disabled @{{else}} add-to-cart-btn @{{/ifEquals}}"
                                            data-toggle="tooltip" data-placement="top"
                                            title="@{{#ifEquals product.type_product 'variants'}} Please select full product attribute! @{{else}} Add to bag @{{/ifEquals}}">Add to Bag</button>
                                </div>
                            </div>
                            <div class="product-tabs">
                                <ul>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
