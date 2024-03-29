<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-01
 * Time: 12:24
 */
?>
@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Chair</a></li>
                <li class="breadcrumb-item">Sofas, sectional & loveseats</li>
                <li class="breadcrumb-item active" aria-current="page">Sasha Round Accent Table</li>
            </ol>
        </nav>
    </div>

    <section class="mb-5">
        <div class="product-detail product-detail-section-page product-detail-item product-detail-item-{{ $productInfo['product']->id }}" data-product-id="{{ $productInfo['product']->id }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 product-detail-wrapper">
                        <div class="product-gallery mb-5" style="background-color: #fff;">
                            <div class="gallery-small">
                                <div class="slider-nav">
                                    @foreach($productInfo['product']->galleries as $productGallery)
                                        <a href="javascript:void(0);" class="item"><img src="{{ asset($productGallery->media) }}" alt=""></a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="gallery-detail">
                                @if($productInfo['product']->is_has_sale)
                                    <div class="badge-sale">Sale</div>
                                @endif
                                <div class="slider-for">
                                    @foreach($productInfo['product']->galleries as $productGallery)
                                        <div class="item"><img src="{{ asset($productGallery->media) }}" alt=""></div>
                                    @endforeach
                                </div>
                                @if($productInfo['product']->available_3d)
                                    <div class="text-right">
                                        <a href="#" class="btn-link-custom">View in Design Ideas</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="product-information">
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-detail-description">Description</div>
                                <div class="content" id="panel-detail-description">
                                    {!! $productInfo['product']->long_desc !!}
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-weight-dimension-description">Weights & Dimensions</div>
                                <div class="content" id="panel-weight-dimension-description">
                                    {!! $productInfo['product']->weight_dimension_description !!}
                                </div>
                            </div>
                            <div class="item">
                                <div class="text-paraph title dark" data-toggle="collapse" href="#panel-toggle-specifications"><span>Specifications</span> <i class="icon fas fa-plus"></i></div>
                                <div class="collapse" id="panel-toggle-specifications">
                                    {!! $productInfo['product']->specification !!}
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
                            @include('pages.partials.review-list')
                        </div>
                        @include('pages.partials.review-post')
                    </div>
                    <div class="col-lg-4">
                        <div class="product-sidebar">
                            <div class="product-specs">
                                <div class="sku">SKU: {{ $productInfo['product']->sku }}</div>
                                <div class="title">{{ $productInfo['product']->name }}</div>
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
                                    @if($productInfo['product']->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                                        <div class="main">${{ ($productInfo['product']->is_has_sale ? number_format($productInfo['product']->sale_price) : number_format($productInfo['product']->price)) }}</div>
                                        @if($productInfo['product']->is_has_sale)
                                            <div class="discount">${{ number_format($productInfo['product']->price) }}</div>
                                            <div class="sale">{{ number_format($productInfo['product']->percent_sale) }}% off</div>
                                        @endif
                                    @else
                                        <div class="main">${{ number_format($productInfo['product']->min_price) }} - ${{ number_format($productInfo['product']->max_price) }}</div>
                                    @endif
                                </div>
                                <div class="feature-items">
                                    <div class="item"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/truck.png') }}" alt="" class="icon"> Free Shipping</div>
                                </div>
                                <div class="choose-color">
                                    @component("components.product-custom-attributes")
                                        @slot("productAttributeValues", $productInfo['product_attribute_values'])
                                        @slot("productAttributes", $productInfo['product_attributes'])
                                        @slot("productDefaultAttributeValues", $productInfo['product_default_attribute_values'])
                                        @slot("typeProduct", $productInfo['product']->type_product)
                                    @endcomponent
                                    <hr>
                                    <div class="d-flex justify-content-between product-quantity-section">
                                        <div class="mr-4">
                                            <span class="d-inline-block gray-color" style="width: 120px;">Select Quantity</span>
                                            <span class="font-weight-600 quantity-product" data-quantity="1">1</span>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" data-action="minus" class="minus-quantity quantity-action action-icon"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/minus-circle.png') }}" alt=""></a>
                                            <a href="javascript:void(0);" data-action="plus" class="plus-quantity quantity-action action-icon"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/plus-circle.png') }}" alt=""></a>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-outline-custom mr-2 add-to-wish-list" data-entity-id="{{ $productInfo['product']->id }}" data-type-entity="{{ \Plugins\Product\Contracts\ProductReferenceConfig::ENTITY_TYPE_PRODUCT }}"><i class="{{ ($productInfo['product']->was_added_wish_list) ? 'fas' : 'far' }} fa-heart mr-2 icon-wish-list"></i> Wishlist</button>
                                    <button class="btn btn-custom btn-block justify-content-center {{ ($productInfo['product']->type_product === \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT) ? 'disabled' : 'add-to-cart-btn' }}"
                                            data-toggle="tooltip" data-placement="top"
                                            title="{{ ($productInfo['product']->type_product === \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT) ? 'Please select full product attribute!' : '' }}">Add to Bag</button>
                                </div>
                            </div>
                            <div class="product-tabs">
                                <ul>
                                    <?php $arrayName = array('Description', 'Weights & Dimensions', 'Specifications', 'Shipping & Returns', 'Reviews');
                                    foreach ($arrayName as $key => $value) { ?>
                                    <li <?php if($key==0) echo 'class="active"'; ?>><a href="#"><?php echo $value; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($productInfo['product_in_collection']->count() > 0)
        <section class="mb-5">
            <div class="container">
                <div class="h6 text-uppercase text-center mb-3">Other items in collection</div>
                <div class="product-slider">
                    <div class="product-slider-wrapper">
                        @foreach($productInfo['product_in_collection'] as $productItemCollection)
                            <div class="px-3 product-item-wrapper">
                                @component("components.product-item")
                                    @slot("productItem", $productItemCollection)

                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($productInfo['similar_products']['data']->count() > 0)
        <section class="mb-5">
            <div class="container">
                <div class="h6 text-uppercase text-center mb-3">Compare Similar Items</div>
                <div class="product-slider">
                    <div class="product-slider-wrapper">
                        @foreach($productInfo['similar_products']['data'] as $similarProduct)
                            <div class="px-3 product-item-wrapper">
                                @component("components.product-item")
                                    @slot("productItem", $similarProduct)

                                @endcomponent
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    @include('partials.modals.quick-shop-modal')
@stop
@section('variable-scripts')
    <script>
        const PRODUCT_ID = {{ $productInfo['product']->id }};
    </script>
    <script id="template-quick-shop-modal" type="text/x-handlebars-template">
        @include('handle-bar.quick-shop-modal')
    </script>

    <script type="text/javascript">
        // Rating Control
        $(".form-rating-control input:radio").attr("checked", false);

        $('.form-rating-control input').click(function () {
            $(".form-rating-control span").removeClass('checked');
            $(this).parent().addClass('checked');
        });

        $(document).on('click', '.btn-write-review', function(event){
            event.preventDefault();
            let content = $('#content-review').val();
            if(!content) return Lcms.showNotice('error', 'Please write content to post a review.', Lcms.languages.notices_msg.error);
            $('#form-post-review').submit();
        });

        let postCommentReview = function (url, content){
            $.ajax({
                url : url,
                type : "post",
                data : { _token : _token, content: content },
                success : function (data){
                    if(!data.error){
                        Lcms.showNotice('success', data.message, Lcms.languages.notices_msg.success);
                        location.reload();
                    }
                    else
                        Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
                },
                error: function(error) { // if error occured
                    Lcms.showNotice('error', error.message || 'Cannot comment for this review.', Lcms.languages.notices_msg.error);  
                }
            })
        }

        $(".post-comment-review").on("keypress",function(e) {
            var key = e.keyCode;
            if (key == 13) {
                let url = $(this).data('url');
                let content = $(this).val();
                if(!content) return Lcms.showNotice('error', 'Please write content to comment a review.', Lcms.languages.notices_msg.error);
                postCommentReview(url, content);
            }
        });
    </script>
@stop