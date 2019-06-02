<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-12
 * Time: 10:42
 */
$currentBusinessSlug = !empty($currentBusinessSlug) ? $currentBusinessSlug : '';
$currentBusinessName = !empty($currentBusinessName) ? $currentBusinessName : '';
$spaces = !empty($spaces) ? $spaces : [];
$tags = !empty($tags) ? $tags : [];
?>
<div class="item-detail look-book-detail item-look-book">
    <img src="{{ URL::asset($urlImage) }}" class="w-100">
    @foreach($tags as $tag)
        <div class="tt-hotspot look-book-tag-product show-popup tt-tag-{{ $tag['id'] }}" style="left: {{ $tag['left'] }}%; top: {{ $tag['top'] }}%;" data-left="{{ $tag['left'] }}" data-top="{{ $tag['top'] }}" data-tag-id="{{ $tag['id'] }}" data-product-id="{{ $tag['product_id'] }}">
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
    <div class="design-ideas-overlay-content is-static">
        <div class="container">
            <div class="row mx-0 justify-content-between align-items-center">
                <div>
                    <div class="title">{{ $nameLookBook }}</div>
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
                <button class="btn btn-outline-custom"><i class="fas fa-heart text-save mr-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>
