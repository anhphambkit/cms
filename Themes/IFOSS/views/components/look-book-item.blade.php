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
?>
<div class="item {{ $typeLookBook }}-look-book item-look-book">
    <img alt="preview image" class="preview_image preview-look-book-image" src="{{ URL::asset($urlImage) }}"/>
    @foreach($tags as $tag)
        <div class="tt-hotspot show-popup look-book-tag-product tt-tag-{{ $tag['id'] }}" style="left: {{ $tag['left'] }}%; top: {{ $tag['top'] }}%;" data-left="{{ $tag['left'] }}" data-top="{{ $tag['top'] }}" data-tag-id="{{ $tag['id'] }}"
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
    @endforeach
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