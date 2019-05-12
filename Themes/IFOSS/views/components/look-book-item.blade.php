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
?>
<div class="item {{ $typeLookBook }}-look-book item-look-book">
    <img src="{{ URL::asset($urlImage) }}"/>
    <div class="design-ideas-overlay-content">
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
</div>