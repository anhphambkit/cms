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
                                    @{{#ifEquals product.type_product "variants"}}
                                        <div class="main">$@{{#if product.is_has_sale }} @{{ product.sale_price }} @{{else}} @{{ product.price }} @{{/if}}</div>
                                        @{{#if product.is_has_sale }}
                                            <div class="discount">$@{{ product.price }}</div>
                                            <div class="sale">@{{ product.percent_sale }}% off</div>
                                        @@{{/if}}
                                    @{{else}}
                                        <div class="main">$@{{ product.min_price }} - $@{{ product.max_price }}</div>
                                    @{{/ifEquals}}
                                </div>
                                <div class="feature-items">
                                    <div class="item"><img src="{{ asset('themes/ifoss/assets/images/icons/truck.png') }}" alt="" class="icon"> Free Shipping</div>
                                </div>
                                <div class="choose-color">

                                    {{--@component("components.product-custom-attributes")--}}
                                        {{--@slot("productAttributeValues", $productInfo['product_attribute_values'])--}}
                                        {{--@slot("productAttributes", $productInfo['product_attributes'])--}}
                                        {{--@slot("productDefaultAttributeValues", $productInfo['product_default_attribute_values'])--}}
                                        {{--@slot("typeProduct", $productInfo['product']->type_product)--}}
                                    {{--@endcomponent--}}
                                    <hr>
                                    <div class="d-flex justify-content-between">
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
