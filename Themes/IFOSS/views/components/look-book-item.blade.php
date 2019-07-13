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
$tags = !empty($tags) ? $tags : [];
$tagProducts = !empty($tagProducts) ? $tagProducts : [];
?>
<div class="item {{ $typeLookBook }}-look-book item-look-book">
    <div class="wrap-look-book-item">
        <img alt="preview image" class="preview_image preview-look-book-image" src="{{ URL::asset($urlImage) }}"/>
        <div class="design-ideas-overlay-content">
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
        <div class="tag-popup-box" style="left: {{ $tag['left'] }}%; top: {{ $tag['top'] }}%;" data-left="{{ $tag['left'] }}">
            <div class="tt-hotspot show-popup look-book-tag-product tt-tag-{{ $tag['id'] }}"  data-top="{{ $tag['top'] }}" data-tag-id="{{ $tag['id'] }}"
                 data-product-id="{{ $tag['product_id'] }}">
                <div class="tt-btn">
                    <i class="icon-tag icon-show-popup fas fa-tag"></i>
                    <i class="icon-tag icon-close-popup fas fa-times"></i>
                </div>
                <input type="number" hidden name="tag[{{ $tag['id'] }}][left]" value="{{ $tag['left'] }}">
                <input type="number" hidden name="tag[{{ $tag['id'] }}][top]" value="{{ $tag['top'] }}">
                <input type="number" hidden name="tag[{{ $tag['id'] }}][product_id]" value="{{ $tag['product_id'] }}">
                <input type="number" hidden name="tag[{{ $tag['id'] }}][product_category_id]" value="{{ $tag['product_category_id'] }}">
            </div>
            @php
                $positionPopup = get_position_popup($tag['left'], $tag['top']);
            @endphp
            <div class="tag-popup-info {{ $positionPopup['class'] }} tag-product-{{ $tag['product_id'] }}" style="left: {{ $positionPopup['left'] }}; {{ $positionPopup['is_top'] ? 'top: ' . $positionPopup['top'] : 'bottom: ' . $positionPopup['bottom'] }};">
                <div class="thumbnail">
                    <img src="{{ $tagProducts[$tag['product_id']]['image_feature'] }}">
                </div>
                <div class="product-specs mb-0">
                    <div class="title">
                        <a href="{{ route('public.product.detail', [ 'url' => $tagProducts[$tag['product_id']]['url_product'] ]) }}" class="link-product-detail">{{ $tagProducts[$tag['product_id']]['name'] }}</a>
                    </div>
                    <div class="price">
                        @if($tagProducts[$tag['product_id']]['type_product'] !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                            <div class="main">${{ ($tagProducts[$tag['product_id']]['is_has_sale'] ? number_format($tagProducts[$tag['product_id']]['sale_price']) : number_format($tagProducts[$tag['product_id']]['price'])) }}</div>
                            @if($tagProducts[$tag['product_id']]['is_has_sale'])
                                <div class="discount">${{ number_format($tagProducts[$tag['product_id']]['price']) }}</div>
                                <div class="sale">{{ number_format($tagProducts[$tag['product_id']]['percent_sale']) }}% off</div>
                            @endif
                        @else
                            <div class="main">${{ number_format($tagProducts[$tag['product_id']]['min_price']) }} - ${{ number_format($tagProducts[$tag['product_id']]['max_price']) }}</div>
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
                    <button class="btn btn-custom btn-sm btn-block justify-content-center">Add to Cart</button>
                </div>
            </div>
        </div>
    @endforeach
</div>