<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-12
 * Time: 08:43
 */

$typeLookBook = !empty($typeLookBook) ? $typeLookBook : 'normal';
$currentBusinessSlug = !empty($currentBusinessSlug) ? $currentBusinessSlug : '';
$currentBusinessName = !empty($currentBusinessName) ? $currentBusinessName : '';
$spaces = !empty($spaces) ? $spaces : [];
$wasAddedWishList = !empty($wasAddedWishList) ? $wasAddedWishList : false;
$tags = !empty($tags) ? $tags : [];
$tagProducts = !empty($tagProducts) ? $tagProducts : [];
$isFullWidthLayout = isset($isFullWidthLayout) ? $isFullWidthLayout : true;
?>
<div class="item {{ $typeLookBook }}-look-book item-look-book {{ !$isFullWidthLayout ? 'small-look-book' : '' }}">
    <div class="content-overlay">
        <img alt="preview image" class="preview-look-book-image" src="{{ URL::asset($urlImage) }}"/>
        <div class="design-ideas-overlay-content">
            <a href="javascript:void(0);" class="wishlist ml-2 float-right add-to-wish-list favourite" data-entity-id="{{ $idLookBook }}" data-type-entity="{{ \Plugins\Product\Contracts\ProductReferenceConfig::ENTITY_TYPE_LOOK_BOOK }}">
                <i class="{{ ($wasAddedWishList) ? 'fas' : 'far' }} fa-heart mr-1 icon-wish-list"></i>
            </a>
            <div class="title">
                <a class="link-look-book btn-link-custom" href="{{ route('public.design-ideal.detail_look_book', [ 'url' => $urlLookBook ]) }}">{{ $nameLookBook }}</a>
            </div>
            <ul class="tag">
                @if(!empty($currentBusinessName) && !empty($currentBusinessSlug))
                    <li>
                        <span class="sub-title-look-book">Business: </span>
                        <a href="{{ route('public.design-ideal.business-type', [ 'businessType' => $currentBusinessSlug ]) }}">{{ $currentBusinessName }}</a>
                    </li>
                    @if(!empty($spaces))
                        <li>
                            <span class="sub-title-look-book">Space: </span>
                            @foreach($spaces as $indexSpace => $space)
                                <a href="{{ route('public.design-ideal.business-type.space', [ 'businessType' => $currentBusinessSlug, 'space' => $space['slug'] ]) }}">{{ $space['text'] }}</a>{{ ($indexSpace < (sizeof($spaces) - 1)) ? ',' : '' }}
                            @endforeach
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
    @foreach($tags as $tag)
        <div class="tag-popup tt-tag-{{ $tag['id'] }}" data-left="{{ $tag['left'] }}" data-top="{{ $tag['top'] }}" data-tag-id="{{ $tag['id'] }}"
             data-product-id="{{ $tag['product_id'] }}" style="left: {{ $tag['left'] }}%; top: {{ $tag['top'] }}%;" >
            <div class="tt-btn">
                <i class="icon-tag icon-show-popup fas fa-tag"></i>
                <i class="icon-tag icon-close-popup fas fa-times"></i>
            </div>
            <input type="number" hidden name="tag[{{ $tag['id'] }}][left]" value="{{ $tag['left'] }}">
            <input type="number" hidden name="tag[{{ $tag['id'] }}][top]" value="{{ $tag['top'] }}">
            <input type="number" hidden name="tag[{{ $tag['id'] }}][product_id]" value="{{ $tag['product_id'] }}">
            <input type="number" hidden name="tag[{{ $tag['id'] }}][product_category_id]" value="{{ $tag['product_category_id'] }}">
            @php
                $positionPopup = get_position_popup($tag['left'], $tag['top']);
            @endphp
            <div class="tag-popup-info tag-xs {{ $positionPopup['class'] }} tag-product-{{ $tag['product_id'] }}" style=" {{ $positionPopup['is_right'] ? 'right: ' . $positionPopup['right'] : 'left: ' . $positionPopup['left'] }}; {{ $positionPopup['is_top'] ? 'top: ' . $positionPopup['top'] : 'bottom: ' . $positionPopup['bottom'] }};">
                <div class="thumbnail">
                    <img src="{{ $tagProducts[$tag['product_id']]['image_feature'] }}" class="content">
                </div>
                <div class="product-specs mb-0 product-detail-item product-item-{{ $tag['product_id'] }} product-detail-item-{{ $tag['product_id'] }}" data-product-id="{{ $tag['product_id'] }}">
                    <div class="title">
                        <a href="{{ route('public.product.detail', [ 'url' => $tagProducts[$tag['product_id']]['url_product'] ]) }}" class="link-product-detail">{{ $tagProducts[$tag['product_id']]['name'] }}</a>
                    </div>
                    <div class="price">
                        @if($tagProducts[$tag['product_id']]['type_product'] !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                            <div class="main d-block">${{ ($tagProducts[$tag['product_id']]['is_has_sale'] ? number_format($tagProducts[$tag['product_id']]['sale_price']) : number_format($tagProducts[$tag['product_id']]['price'])) }}</div>
                            @if($tagProducts[$tag['product_id']]['is_has_sale'])
                                <div class="discount">${{ number_format($tagProducts[$tag['product_id']]['price']) }}</div>
                                <div class="sale">{{ number_format($tagProducts[$tag['product_id']]['percent_sale']) }}% off</div>
                            @endif
                        @else
                            <div class="main d-block">${{ number_format($tagProducts[$tag['product_id']]['min_price']) }} - ${{ number_format($tagProducts[$tag['product_id']]['max_price']) }}</div>
                        @endif
                    </div>
                    <div class="rating">
                        <div class="rating-star">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star unrate"></i>
                        </div>
                        <a href="#" class="reviews">6,415 reviews</a>
                    </div>
                    <button class="btn btn-custom btn-sm justify-content-center add-to-cart-btn">Add to Cart</button>
                </div>
            </div>
        </div>
    @endforeach
</div>