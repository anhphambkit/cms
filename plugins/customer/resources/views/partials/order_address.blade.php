@php
	$addressKey = $addressKey ?? 'address_billing';
	$address = get_order_address_default($order, $addressKey);
@endphp

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.first_name")) has-error @endif">
    <label for="{{ $addressKey }}[first_name]">{{ trans('plugins-customer::order.forms.first_name') }}</label>
    {!! Form::text("{$addressKey}[first_name]", get_address_value_default($address, 'first_name'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.first_name'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.first_name", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.last_name")) has-error @endif">
    <label for="{{ $addressKey }}[last_name]">{{ trans('plugins-customer::order.forms.last_name') }}</label>
    {!! Form::text("{$addressKey}[last_name]", get_address_value_default($address, 'last_name'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.last_name'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.last_name", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.address_1")) has-error @endif">
    <label for="{{ $addressKey }}[address_1]">{{ trans('plugins-customer::order.forms.address_1') }}</label>
    {!! Form::text("{$addressKey}[address_1]", get_address_value_default($address, 'address_1'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.address_1'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.address_1", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.address_2")) has-error @endif">
    <label for="{{ $addressKey }}[address_2]">{{ trans('plugins-customer::order.forms.address_2') }}</label>
    {!! Form::text("{$addressKey}[address_2]", get_address_value_default($address, 'address_2'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.address_2'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.address_2", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.city")) has-error @endif">
    <label for="{{ $addressKey }}[city]">{{ trans('plugins-customer::order.forms.city') }}</label>
    {!! Form::text("{$addressKey}[city]", get_address_value_default($address, 'city'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.city'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.city", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.state")) has-error @endif">
    <label for="{{ $addressKey }}[state]">{{ trans('plugins-customer::order.forms.state') }}</label>
    <!-- {!! Form::text("{$addressKey}[state]", get_address_value_default($address, 'state'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.state'), 'data-counter' => 120]) !!} -->

    {!! Form::select("{$addressKey}[state]", $states , get_address_value_default($address, 'state'), ['class' => 'form-control roles-list']) !!}
    {!! Form::error("{$addressKey}.state", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.company_name")) has-error @endif">
    <label for="{{ $addressKey }}[company_name]">{{ trans('plugins-customer::order.forms.company_name') }}</label>
    {!! Form::text("{$addressKey}[company_name]", get_address_value_default($address, 'company_name'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.company_name'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.company_name", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.zip")) has-error @endif">
    <label for="{{ $addressKey }}[zip]">{{ trans('plugins-customer::order.forms.zip') }}</label>
    {!! Form::text("{$addressKey}[zip]", get_address_value_default($address, 'zip'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.zip'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.zip", $errors) !!}
</div>

<div class="form-group col-md-12 mb-2 @if ($errors->has("{$addressKey}.phone_number")) has-error @endif">
    <label for="{{ $addressKey }}[phone_number]">{{ trans('plugins-customer::order.forms.phone_number') }}</label>
    {!! Form::text("{$addressKey}[phone_number]", get_address_value_default($address, 'phone_number'), ['class' => 'form-control', 'placeholder' => trans('plugins-customer::order.forms.phone_number'), 'data-counter' => 120]) !!}
    {!! Form::error("{$addressKey}.phone_number", $errors) !!}
</div>
