<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-21
 * Time: 10:20
 */
?>
<div class="modal fade" id="look-book-tag-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="look-book-tag-modal-label"><i class="til_img"></i><strong>{{ trans('plugins-product::look-book.modal_select_product_look_book') }}</strong></h4>
            </div>
            <div class="modal-body">
                <div class="form-body">
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label required" for="role">{{ trans('core-base::forms.category') }}</label>
                            {!! Form::select('category_id', $categories, null, ['class' => 'select2-placeholder-multiple form-control category-list', "id" => "select-category-list" ]) !!}
                        </div>
                    </div>
                    {{-- Image--}}
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label class="control-label required" for="role">{{ trans('plugins-product::product.name') }}</label>
                            {!! Form::select('product_id', $products, null, ['class' => 'select2-placeholder-multiple form-control product-list', "id" => "select-product-list" ]) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">{{ trans('core-base::forms.cancel') }}</button>
                <button class="btn btn-primary look-book-tag-save" type="button">{{ trans('core-base::forms.create') }}</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->
