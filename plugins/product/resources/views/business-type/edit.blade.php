@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.product.business-type.edit', $infoBusinessType->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PRODUCT_MODULE_SCREEN_NAME, request(), $infoBusinessType) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-product::business-type.edit') }}</h4>
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
                                        {!! Form::text('name', $infoBusinessType->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('parent_id')) has-error @endif">
                                        <label class="control-label required" for="role">{{ trans('core-base::forms.parent_category') }}</label>
                                        {!! Form::select('parent_id', $businessTypes, $infoBusinessType->parent_id, ['class' => 'select2-placeholder-multiple form-control business-type-list', "id" => "select-business-type-list" ]) !!}
                                        {!! Form::error('parent_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('order')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.order') }}</label>
                                        {!! Form::number('order', $infoBusinessType->order, ['class' => 'form-control', 'id' => 'order', 'type' => 'number', 'min' => 0, 'placeholder' => trans('core-base::forms.name_placeholder')]) !!}
                                        {!! Form::error('order', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.description') }}</label>
                                        {!! render_editor('description', $infoBusinessType->description, true) !!}
                                        {!! Form::error('description', $errors) !!}
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
                @include('core-base::elements.forms.status', ['selected' => $infoBusinessType->status])
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'top', $infoBusinessType) @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCT_MODULE_SCREEN_NAME, 'side', $infoBusinessType) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop