<div class="form-group form-group-s1">
    <input type="text" class="form-control form-control-lg squared" value="{{ $address->address_1 }}" placeholder="Address Line 1*" name="address[{{ $key }}][address_1]"/>
</div>
<div class="form-group form-group-s1">
    <input type="text" class="form-control form-control-lg squared" value="{{ $address->address_2 }}" placeholder="Address Line 2*" name="address[{{ $key }}][address_2]"/>
</div>
<div class="form-group form-group-s1">
    <input type="text" class="form-control form-control-lg squared" value="{{ $address->city }}" placeholder="City/Town" name="address[{{ $key }}][city]"/>
</div>
<div class="row section-address">
    <div class="col-md-6">
        <div class="form-group form-group-s1">
            <select class="form-control form-control-lg squared" name="address[{{ $key }}][state]">
                <option value="">State</option>
                @foreach(get_states() as $state)
                    <option value="{{ $state->id }}" @if($address->state == $state->id) selected @endif>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group form-group-s1">
            <input type="text" class="form-control form-control-lg squared" value="{{ $address->city }}" placeholder="Zip" name="address[{{ $key }}][zip]"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="checkbox checkbox-custom checkbox-circle pl-2">
                <input class="address-type" id="checkbox-circle-circle-residential-{{ $key }}" type="checkbox" name="address[{{ $key }}][is_residential_address]" @if($address->is_residential_address ?? false) checked @endif/>
                <label for="checkbox-circle-circle-residential-{{ $key }}">Residential Address</label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="checkbox checkbox-custom checkbox-circle pl-2">
                <input class="address-type" id="checkbox-circle-circle-business-{{ $key }}" type="checkbox" name="address[{{ $key }}][is_business_address]"  @if($address->is_business_address ?? false) checked @endif />
                <label for="checkbox-circle-circle-business-{{ $key }}">Business/Commercial Address</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group form-group-s1">
    <input type="text" class="form-control form-control-lg squared" value="{{ $address->company_name }}" placeholder="Company Name" name="address[{{ $key }}][company_name]"/>
</div>
<div class="form-group form-group-s1">
    <input type="text" class="form-control form-control-lg squared" value="{{ $address->phone_number }}" placeholder="Phone Number" name="address[{{ $key }}][phone_number]"/>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="checkbox checkbox-custom checkbox-circle pl-2">
                <input class="is_default_shipping" id="checkbox-circle-circle-shipping-{{ $key }}" type="checkbox" name="address[{{ $key }}][is_default_shipping]" @if($address->is_default_shipping ?? false) checked @endif/>
                <label for="checkbox-circle-circle-shipping-{{ $key }}">Make this my default shipping address</label>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="checkbox checkbox-custom checkbox-circle pl-2">
                <input class="is_default_billing" id="checkbox-circle-circle-billing-{{ $key }}" type="checkbox" name="address[{{ $key }}][is_default_billing]" @if($address->is_default_billing ?? false) checked @endif/>
                <label for="checkbox-circle-circle-billing-{{ $key }}">Make this my default billing address</label>
            </div>
        </div>
    </div>
</div>
<hr>