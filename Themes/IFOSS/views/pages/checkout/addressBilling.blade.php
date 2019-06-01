@php
	$address = get_customer_address_default(false);
@endphp

<div class="form-group row @if ($errors->has('address_billing.fullname')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Full Name <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_billing[fullname]" type="text" value="{{ get_current_customer()->username }}" class="form-control form-control-lg squared @if ($errors->has('address_billing.fullname')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_billing.fullname', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_billing.address_1')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Address Line 1 <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_billing[address_1]" value="{{ get_address_value_default($address, 'address_1') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_billing.address_1')) is-invalid @endif" placeholder="Street address, P.O.box, company name, c/o"/>
		{!! $errors->first('address_billing.address_1', '<span class="invalid-feedback">:message</span>') !!}
		<div class="ml-3 mt-1 font-size-12 font-weight-500">Ex: Street address, P.O.box, company name, c/o</div>
	</div>
</div>
<div class="form-group row @if ($errors->has('address_billing.address_2')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Address Line 2</label>
	<div class="col-sm-9">
		<input name="address_billing[address_2]" value="{{ get_address_value_default($address, 'address_2') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_billing.address_2')) is-invalid @endif" placeholder="Apartment, suite, unit, building, floor, etc"/>
		{!! $errors->first('address_billing.address_2', '<span class="invalid-feedback">:message</span>') !!}
		<div class="ml-3 mt-1 font-size-12 font-weight-500">Ex: Apartment, suite, unit, building, floor, etc</div>
	</div>
</div>

<div class="form-group row @if ($errors->has('address_billing.city')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Town / City <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_billing[city]" value="{{ get_address_value_default($address, 'city') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_billing.city')) is-invalid @endif" placeholder="Apartment, suite, unit, building, floor, etc"/>
		{!! $errors->first('address_billing.city', '<span class="invalid-feedback">:message</span>') !!}
		<div class="ml-3 mt-1 font-size-12 font-weight-500">Ex: Apartment, suite, unit, building, floor, etc</div>
	</div>
</div>
<div class="form-group row @if ($errors->has('address_billing.state')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">State <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<select class="form-control form-control-lg squared @if ($errors->has('address_billing.state')) is-invalid @endif" name="address_billing[state]">
			<option value="">State</option>
            @foreach(get_states() as $state)
                <option value="{{ $state->id }}" @if(get_address_value_default($address, 'state') == $state->id) selected @endif>{{ $state->name }}</option>
            @endforeach
		</select>
		{!! $errors->first('address_billing.state', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_billing.zip')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Postcode/Zip <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_billing[zip]" value="{{ get_address_value_default($address, 'zip') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_billing.zip')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_billing.zip', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_billing.phone_number')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Phone Number <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_billing[phone_number]" value="{{ get_address_value_default($address, 'phone_number') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_billing.phone_number')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_billing.phone_number', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>