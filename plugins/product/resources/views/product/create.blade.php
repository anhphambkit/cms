@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => 'admin.product.create']) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), null) @endphp
        <div class="row">
            <div class="col-md-9">
                {{--General--}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.general') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
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
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('category_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('core-base::forms.parent_category') }}</label>
                                        {!! Form::select('category_id[]', $categories, null, ['class' => 'select2-placeholder-multiple form-control category-list', "id" => "select-category-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('category_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('manufacturer_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.manufacturer') }}</label>
                                        {!! Form::select('manufacturer_id', $manufacturer, null, ['class' => 'select2-placeholder-multiple form-control manufacturer-list', "id" => "select-manufacturer-list" ]) !!}
                                        {!! Form::error('manufacturer_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('collection_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.collection') }}</label>
                                        {!! Form::select('collection_id[]', $collections, null, ['class' => 'select2-placeholder-multiple form-control collection-list', "id" => "select-collection-list", "multiple" => "multiple" ]) !!}
                                        {!! Form::error('collection_id', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--End General--}}

                {{--Price Info--}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.price_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
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
                                    <div class="form-group col-md-4 mb-2 @if ($errors->has('inventory')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.inventory') }}</label>
                                        {!! Form::number('inventory', old('inventory'), ['class' => 'form-control', 'id' => 'inventory', 'type' => 'number', 'min' => 0, 'placeholder' => trans('plugins-product::product.form.inventory_placeholder')]) !!}
                                        {!! Form::error('inventory', $errors) !!}
                                    </div>
                                </div>

                                @include('plugins-product::look-book.partials.list-space-business-selected')

                            </div>
                        </div>
                    </div>
                </div>
                {{--End Price Info--}}

                {{--Start Card Attributes/Variants--}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.variant_attribute') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="nav-vertical nav-variant">
                                    <ul class="nav nav-tabs nav-left nav-border-left">
                                        <li class="nav-item">
                                            <a class="nav-link active nav-tab-vertical-custom" id="attribute-variants-tab-panel-tab1" data-toggle="tab" aria-controls="tab-attribute-product" href="#tab-attribute-product" aria-expanded="true"><i class="fas fa-grip-horizontal"></i> {{ trans('plugins-product::product.attributes') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link nav-tab-vertical-custom" id="attribute-variants-tab-panel-tab2" data-toggle="tab" aria-controls="tab-variant-product" href="#tab-variant-product" aria-expanded="false"><i class="fas fa-outdent"></i> {{ trans('plugins-product::product.variants') }}</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content px-1">
                                        <div role="tabpanel" class="tab-pane active" id="tab-attribute-product" aria-expanded="true" aria-labelledby="attribute-variants-tab-panel-tab1">
                                            <div class="container form-body">
                                                <div class="row product-attribute-add-area">
                                                    <div class="form-group col-md-4 mb-2">
                                                        <label class="control-label" for="select-product-attributes-list">{{ trans('plugins-product::product.attributes') }}</label>
                                                        {!! Form::select('', $productAttributes, '', ['class' => 'form-control product-attributes-list', "id" => "select-product-attributes-list" ]) !!}
                                                    </div>
                                                    <div class="form-group col-md-4 mb-2 add-attribute-btn">
                                                        <label class="control-label" for="btn-add-attribute">{{ trans('plugins-product::product.action') }}</label>
                                                        <div class="btn-middle-line">
                                                            <button type="button" class="btn btn-info btn-add-attribute">
                                                                <i class="far fa-plus-square"></i> {{ trans('core-base::forms.add') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="attribute-render-area">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-variant-product" aria-labelledby="attribute-variants-tab-panel-tab2">
                                            <div class="container form-body">
                                                <div class="variant-products-area">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Card Attributes/Variants--}}

                {{--Start Description--}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.description_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('long_desc')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.long_desc') }}</label>
                                        {!! render_editor('long_desc', old('long_desc'), true) !!}
                                        {!! Form::error('long_desc', $errors) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('short_description')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.short_description') }}</label>
                                        {!! render_editor('short_description', old('short_description'), true) !!}
                                        {!! Form::error('short_description', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--End Description--}}

                {{--Start Weight/dimensions and specifications--}}
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::product.ship_specification_info') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
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
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('weight_dimension_description')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.weight_dimension_description') }}</label>
                                        {!! render_editor('weight_dimension_description', old('weight_dimension_description'), true) !!}
                                        {!! Form::error('weight_dimension_description', $errors) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('specification')) has-error @endif">
                                        <label for="name">{{ trans('plugins-product::product.form.specification') }}</label>
                                        {!! render_editor('specification', old('specification'), true) !!}
                                        {!! Form::error('specification', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--End Weight/dimensions and specifications--}}

                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'advanced') @endphp
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status')
                {{--Option render--}}
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <div class="widget meta-boxes meta-box-custom">
                            <div class="widget-title">
                                <h4>
                                    <span class="required">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.other_information') }}</label>
                                    </span>
                                </h4>
                            </div>
                            <div class="widget-body">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('is_best_seller')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.is_best_seller') }}</label>
                                        {!! Form::checkbox('is_best_seller', true, old('is_best_seller'), ['class' => 'form-control switchery', 'id' => 'is_best_seller', 'placeholder' => trans('plugins-product::product.form.is_best_seller_placeholder')]) !!}
                                        {!! Form::error('is_best_seller', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('available_3d')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.available_3d') }}</label>
                                        {!! Form::checkbox('available_3d', true, old('available_3d'), ['class' => 'form-control switchery', 'id' => 'available_3d', 'placeholder' => trans('plugins-product::product.form.available_3d_placeholder')]) !!}
                                        {!! Form::error('available_3d', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('has_assembly')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.has_assembly') }}</label>
                                        {!! Form::checkbox('has_assembly', true, old('has_assembly'), ['class' => 'form-control switchery', 'id' => 'has_assembly', 'placeholder' => trans('plugins-product::product.form.has_assembly_placeholder')]) !!}
                                        {!! Form::error('has_assembly', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('is_outdoor')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('plugins-product::product.form.is_outdoor') }}</label>
                                        {!! Form::checkbox('is_outdoor', true, old('is_outdoor'), ['class' => 'form-control switchery', 'id' => 'is_outdoor', 'placeholder' => trans('plugins-product::product.form.is_outdoor_placeholder')]) !!}
                                        {!! Form::error('is_outdoor', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{--Option render--}}

                {{-- Image--}}
                <div class="row">
                    <div class="form-group col-md-12 mb-2">
                        <div class="widget meta-boxes meta-box-custom">
                            <div class="widget-title">
                                <h4>
                            <span class="required @if ($errors->has('image_feature')) has-error @endif">
                                <label class="control-label required" for="role">{{ trans('plugins-product::product.form.image_feature') }}</label>
                            </span>
                                </h4>
                            </div>
                            <div class="widget-body">
                                {!! Form::mediaImage('image_feature', old('image_feature')) !!}
                                {!! Form::error('image_feature', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--End Image--}}

                {{-- Gallery--}}
                <div class="row">
                    <div class="form-group col-md-12 mb-2 @if ($errors->has('image_gallery')) has-error @endif">
                        <div class="widget meta-boxes gallery-box meta-box-custom">
                            <div class="widget-title">
                                <h4><span class="required">{{ trans('plugins-product::product.form.image_gallery') }}</span></h4>
                            </div>
                            <div class="widget-body">
                                {!! Form::mediaGallery('image_gallery', null) !!}
                                {!! Form::error('image_gallery', $errors) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {{--End Gallery--}}
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top') @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side') @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop

@section('variable-scripts')
    <script>
        const API = {
            GET_SPACES_BY_BUSINESS_TYPE : "{{ route('ajax.admin.get_spaces_by_business_type') }}",
            GET_ALL_SPACES : "{{ route('ajax.admin.get_all_spaces') }}",
            GET_DEFAULT_BUSINESS_TYPE : "{{ route('ajax.admin.get_default_business_type') }}",
            GET_LIST_VALUE_OF_ATTRIBUTE : "{{ route('ajax.admin.get_list_value_custom_attributes') }}",
            GET_CUSTOM_ATTRIBUTES : "{{ route('ajax.admin.get_custom_attributes') }}",
        };
        const BUSINESS_SPACE_INDEX = 1;
        const ALL_SPACE_INDEX = 1;
        const ALL_SPACES = {!! json_encode($spaces) !!};
        const PRODUCT_ATTRIBUTES = {!! json_encode($productAttributes) !!};
    </script>
@stop