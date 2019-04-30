<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-27
 * Time: 08:28
 */
$businessTypesArray = $businessTypes;
reset($businessTypesArray);
$defaultBusinessType = key($businessTypesArray);
$businessSpaces = !empty($businessSpaces) ? $businessSpaces : [
    [
        'index' => 0,
        'business_type_id' => $defaultBusinessType,
        'space_id' => 0,
    ]
];
?>
<div class="space-business-select-area">
    <div class="render-space-business-select">
        @foreach($businessSpaces as $key => $businessSpace)
            <div class="row business-space-row-{{$key}}">
                <div class="form-group col-md-5 mb-2 @if ($errors->has('business_type_id')) has-error @endif">
                    <label class="control-label required" for="select-business-type">{{ trans('plugins-product::product.form.business_type') }}</label>
                    {!! Form::select("space_business[{$key}][business_type_id]", $businessTypes, $businessSpace['business_type_id'], ['class' => "select2-placeholder-multiple form-control select-business-type-{$key} select-business-type-list", 'data-business-type-index' => $key ]) !!}
                    {!! Form::error("space_business[{$key}][business_type_id]", $errors) !!}
                </div>
                <div class="form-group col-md-5 mb-2 @if ($errors->has('space_id')) has-error @endif">
                    <label class="control-label required" for="select-space">{{ trans('plugins-product::product.form.space') }}</label>
                    {!! Form::select("space_business[{$key}][space_id]", $spaces, $businessSpace['space_id'], ['class' => "select2-placeholder-multiple form-control select-space-{$key} select-space-list", 'data-space-index' => $key, 'data-init-space-id' => $businessSpace['space_id'] ]) !!}
                    {!! Form::error("space_business[{$key}][space_id]", $errors) !!}
                </div>
                <div class="form-group col-md-2 mb-2">
                    <label class="control-label" for="action-space">{{ trans('plugins-product::space.form.action') }}</label>
                    <div class="action-space-area">
                        {{--<a class="action-space edit-business-space edit-business-space-{{$key}}" data-business-space-index="{{$key}}">--}}
                            {{--<i class="far fa-edit icon-business-space-edit"></i>--}}
                            {{--{{ trans('core-base::forms.edit') }}--}}
                        {{--</a>--}}
                        <a class="action-space delete-business-space delete-business-space-{{$key}}" data-business-space-index="{{$key}}">
                            <i class="far fa-trash-alt icon-business-space-delete"></i>
                            {{ trans('core-base::forms.delete') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="form-group col-md-3 mb-2">
            <button class="btn btn-info add-space-business" type="button">{{ trans('plugins-product::space.form.add_space') }}</button>
        </div>
    </div>
</div>
