@php
	$address = get_customer_address_default();
@endphp

<div class="form-group row @if ($errors->has('address_shipping.first_name')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">First Name <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[first_name]" type="text" value="{{ old('address_shipping.first_name') }}" class="form-control form-control-lg squared @if ($errors->has('address_shipping.first_name')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_shipping.first_name', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.last_name')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Last Name <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[last_name]" type="text" value="{{ old('address_shipping.last_name') }}" class="form-control form-control-lg squared @if ($errors->has('address_shipping.last_name')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_shipping.last_name', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.email')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Email <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[email]" type="text" value="{{ old('address_shipping.email') }}" class="form-control form-control-lg squared @if ($errors->has('address_shipping.email')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_shipping.email', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.address_1')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Address Line 1 <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[address_1]" value="{{ get_address_value_default($address, 'address_1') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_shipping.address_1')) is-invalid @endif" placeholder="Street address, P.O.box, company name, c/o"/>
		{!! $errors->first('address_shipping.address_1', '<span class="invalid-feedback">:message</span>') !!}
		<div class="ml-3 mt-1 font-size-12 font-weight-500">Ex: Street address, P.O.box, company name, c/o</div>
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.address_2')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Address Line 2</label>
	<div class="col-sm-9">
		<input name="address_shipping[address_2]" value="{{ get_address_value_default($address, 'address_2') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_shipping.address_2')) is-invalid @endif" placeholder="Apartment, suite, unit, building, floor, etc"/>
		{!! $errors->first('address_shipping.address_2', '<span class="invalid-feedback">:message</span>') !!}
		<div class="ml-3 mt-1 font-size-12 font-weight-500">Ex: Apartment, suite, unit, building, floor, etc</div>
	</div>
</div>

<div class="form-group row @if ($errors->has('address_shipping.city')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Town / City <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[city]" value="{{ get_address_value_default($address, 'city') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_shipping.city')) is-invalid @endif" placeholder="Apartment, suite, unit, building, floor, etc"/>
		{!! $errors->first('address_shipping.city', '<span class="invalid-feedback">:message</span>') !!}
		<div class="ml-3 mt-1 font-size-12 font-weight-500">Ex: Apartment, suite, unit, building, floor, etc</div>
	</div>
</div>

<div class="form-group row @if ($errors->has('address_shipping.company_name')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Company Name</label>
	<div class="col-sm-9">
		<input name="address_shipping[company_name]" value="{{ get_address_value_default($address, 'company_name') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_shipping.company_name')) is-invalid @endif" placeholder="Apartment, suite, unit, building, floor, etc"/>
		{!! $errors->first('address_shipping.company_name', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.state')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">State <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<select class="form-control form-control-lg squared @if ($errors->has('address_shipping.state')) is-invalid @endif" name="address_shipping[state]">
			<option value="">State</option>
            @foreach(get_states() as $state)
                <option value="{{ $state->id }}" @if(get_address_value_default($address, 'state') == $state->id) selected @endif>{{ $state->name }}</option>
            @endforeach
		</select>
		{!! $errors->first('address_shipping.state', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.zip')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Postcode/Zip <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[zip]" value="{{ get_address_value_default($address, 'zip') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_shipping.zip')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_shipping.zip', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>
<div class="form-group row @if ($errors->has('address_shipping.phone_number')) has-error @endif">
	<label class="col-sm-3 col-form-label align-items-center d-flex">Phone Number <span class="text-red">*</span></label>
	<div class="col-sm-9">
		<input name="address_shipping[phone_number]" value="{{ get_address_value_default($address, 'phone_number') }}" type="text" class="form-control form-control-lg squared @if ($errors->has('address_shipping.phone_number')) is-invalid @endif" placeholder=""/>
		{!! $errors->first('address_shipping.phone_number', '<span class="invalid-feedback">:message</span>') !!}
	</div>
</div>