<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 10:05
 */
?>
<div class="look-book-area row">
    <div class="image-look-book form-group col-md-12 mb-2">
        <input type="hidden"
               name="{{ $name }}"
               value="{{ $value }}"
               class="image-data">
        <img src="{{ $value }}"
             alt="preview image" class="preview_image preview-look-book-image">
        <div class="image-box-actions">
            <a class="btn_gallery" data-result="{{ $name }}" data-action="look-book-image" data-multiple="true">
                {{ trans('core-base::forms.choose_image') }}
            </a> |
            <a class="btn_remove_look_book_image">
                {{ trans('core-base::forms.remove_image') }}
            </a>
        </div>
    </div>
    {{--<div class="col-md-4">--}}
        {{--ahihi--}}
    {{--</div>--}}
</div>
