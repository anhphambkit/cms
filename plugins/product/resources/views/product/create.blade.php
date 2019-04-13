@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.product.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.create') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.name') }}</label>
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('upc')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.upc') }}</label>
                                        {!! Form::text('upc', old('upc'), ['class' => 'form-control', 'id' => 'upc', 'placeholder' => trans('plugins-product::product.form.upc_placeholder'), 'data-counter' => 60]) !!}
                                        {!! Form::error('upc', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('sku')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.sku') }}</label>
                                        {!! Form::text('sku', old('sku'), ['class' => 'form-control', 'id' => 'sku', 'placeholder' => trans('plugins-product::product.form.sku_placeholder'), 'data-counter' => 2]) !!}
                                        {!! Form::error('sku', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('category_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('core-base::forms.parent_category') }}</label>
                                        {!! Form::select('category_id', $categories, null, ['class' => 'select2-placeholder-multiple form-control category-list', "id" => "select-category-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('category_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('brand_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.brand') }}</label>
                                        {!! Form::select('brand_id', $brand, null, ['class' => 'select2-placeholder-multiple form-control brand-list', "id" => "select-brand-list" ]) !!}
                                        {!! Form::error('brand_id', $errors) !!}
                                    </div>
                                </div>
                                {{-- Image--}}
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('image_feature')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.image_feature') }}</label>
                                        {!! Form::mediaImage('image_feature', null, [ 'action' => 'select-image' ]) !!}
                                    </div>
                                </div>
                                {{--End Image--}}
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('price')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.price') }}</label>
                                        {!! Form::number('price', old('price'), ['class' => 'form-control', 'id' => 'price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.price_placeholder')]) !!}
                                        {!! Form::error('price', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('sale_price')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.sale_price') }}</label>
                                        {!! Form::number('sale_price', old('sale_price'), ['class' => 'form-control', 'id' => 'sale_price', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.sale_price_placeholder')]) !!}
                                        {!! Form::error('sale_price', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('in_stock')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.in_stock') }}</label>
                                        {!! Form::number('in_stock', old('in_stock'), ['class' => 'form-control', 'id' => 'in_stock', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.in_stock_placeholder')]) !!}
                                        {!! Form::error('in_stock', $errors) !!}
                                    </div>
                                </div>
                                {{--category--}}
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('business_type_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.business_type') }}</label>
                                        {!! Form::select('business_type_id', $businessTypes, null, ['class' => 'select2-placeholder-multiple form-control business_type-list', "id" => "select-business_type-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('business_type_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('collection_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.collection') }}</label>
                                        {!! Form::select('collection_id', $collections, null, ['class' => 'select2-placeholder-multiple form-control collection-list', "id" => "select-collection-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('collection_id', $errors) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('material_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.material') }}</label>
                                        {!! Form::select('material_id', $materials, null, ['class' => 'select2-placeholder-multiple form-control material-list', "id" => "select-material-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('material_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('color_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.color') }}</label>
                                        {!! Form::select('color_id', $colors, null, ['class' => 'select2-placeholder-multiple form-control color-list', "id" => "select-color-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('color_id', $errors) !!}
                                    </div>
                                </div>
                                {{--category--}}
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('short_description')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.short_description') }}</label>
                                        {!! render_editor('short_description', old('short_description'), true) !!}
                                        {!! Form::error('short_description', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('long_desc')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.long_desc') }}</label>
                                        {!! render_editor('long_desc', old('long_desc'), true) !!}
                                        {!! Form::error('long_desc', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('product_dimension')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.product_dimension') }}</label>
                                        {!! Form::text('product_dimension', old('product_dimension'), ['class' => 'form-control', 'id' => 'product_dimension', 'placeholder' => trans('plugins-product::product.form.product_dimension_placeholder'), 'data-counter' => 60]) !!}
                                        {!! Form::error('product_dimension', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('package_dimension')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.package_dimension') }}</label>
                                        {!! Form::text('package_dimension', old('package_dimension'), ['class' => 'form-control', 'id' => 'package_dimension', 'placeholder' => trans('plugins-product::product.form.package_dimension_placeholder'), 'data-counter' => 60]) !!}
                                        {!! Form::error('package_dimension', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('product_weight')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.product_weight') }}</label>
                                        {!! Form::number('product_weight', old('product_weight'), ['class' => 'form-control', 'id' => 'product_weight', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.product_weight_placeholder')]) !!}
                                        {!! Form::error('product_weight', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-3 mb-2 @if ($errors->has('package_weight')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.package_weight') }}</label>
                                        {!! Form::number('package_weight', old('package_weight'), ['class' => 'form-control', 'id' => 'package_weight', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.package_weight_placeholder')]) !!}
                                        {!! Form::error('package_weight', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('is_best_seller')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.is_best_seller') }}</label>
                                        {!! Form::checkbox('is_best_seller', old('is_best_seller'), false, ['class' => 'form-control switchery', 'id' => 'is_best_seller', 'placeholder' => trans('plugins-product::product.form.is_best_seller_placeholder')]) !!}
                                        {!! Form::error('is_best_seller', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('has_design')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.has_design') }}</label>
                                        {!! Form::checkbox('has_design', old('has_design'), true, ['class' => 'form-control switchery', 'id' => 'has_design', 'placeholder' => trans('plugins-product::product.form.has_design_placeholder')]) !!}
                                        {!! Form::error('has_design', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('has_assembly')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.has_assembly') }}</label>
                                        {!! Form::checkbox('has_assembly', old('has_assembly'), true, ['class' => 'form-control switchery', 'id' => 'has_assembly', 'placeholder' => trans('plugins-product::product.form.has_assembly_placeholder')]) !!}
                                        {!! Form::error('has_assembly', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop