@php
	use Plugins\Payment\Contracts\PaymentReferenceConfig;
	$cardType = [
		'visa'       => PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_VISA,
		'mastercard' => PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_MASTER,
		'discover'   => PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_DISCOVER,
		'amex'       => PaymentReferenceConfig::REFERENCE_PAYMENT_PAYPAL_CARD_NAME_AMEX,
	];
@endphp

<div class="text-uppercase text-center mb-3 font-size-12 font-weight-500" style="color: #51887f;">Add Credit or Debit Card</div>
<div class="p-4 bg-white mb-3" style="border: 1px solid #96c4bd;">
	<div class="d-flex mb-2" id="tab-card-type">
		<a href="#" class="btn-tab w-100 p-0 mr-2" attr-name="{{ $cardType['visa'] }}"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/visa-logo.png') }}" class="w-100"></a>
		<a href="#" class="btn-tab w-100 p-0 mr-2" attr-name="{{ $cardType['mastercard'] }}"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/mastercard-logo.png') }}" class="w-100"></a>
		<a href="#" class="btn-tab w-100 p-0 mr-2" attr-name="{{ $cardType['discover'] }}"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/amex-logo.png') }}" class="w-100"></a>
		<a href="#" class="btn-tab w-100 p-0" attr-name="{{ $cardType['amex'] }}"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/discover-logo.png') }}" class="w-100"></a>
	</div>
	<div class="form-group-fl @if ($errors->has('creditcard.card_number')) has-error @endif">
		<input type="text" class="form-control-fl @if ($errors->has('creditcard.card_number')) is-invalid @endif" placeholder="Card number *" name="creditcard[card_number]" value="{{ old('creditcard.card_number') }}">
		{!! $errors->first('creditcard.card_number', '<span class="invalid-feedback">:message</span>') !!}
	</div>
	<div class="font-size-12 font-weight-500 my-4" style="color: #acacac;">Expiration date</div>
	<div class="row">
		<div class="col-md-4 @if ($errors->has('creditcard.expiration_month')) has-error @endif">
			<select class="form-control form-control-lg squared @if ($errors->has('creditcard.expiration_month')) is-invalid @endif" name="creditcard[expiration_month]" >
				<option value="">Month</option>
				@for($month = 1; $month <= 12; $month++)
					<option value="{{ $month }}" @if(old('creditcard.expiration_month') == $month) selected @endif>{{ $month }}</option>
				@endfor
			</select>
			{!! $errors->first('creditcard.expiration_month', '<span class="invalid-feedback">:message</span>') !!}
		</div>
		<div class="col-md-4 @if ($errors->has('creditcard.expiration_year')) has-error @endif">
			<select class="form-control form-control-lg squared @if ($errors->has('creditcard.expiration_year')) is-invalid @endif" name="creditcard[expiration_year]">
				<option value="">Year</option>
				@for($year = 2018; $year <= 2050; $year++)
					<option value="{{ $year }}" @if(old('creditcard.expiration_year') == $year) selected @endif>{{ $year }}</option>
				@endfor
			</select>
			{!! $errors->first('creditcard.expiration_year', '<span class="invalid-feedback">:message</span>') !!}
		</div>
		<div class="col-md-4 @if ($errors->has('creditcard.card_cvv')) has-error @endif">
			<input type="text" class="form-control form-control-lg squared @if ($errors->has('creditcard.card_cvv')) is-invalid @endif" placeholder="CVV" name="creditcard[card_cvv]" value="{{ old('creditcard.card_cvv') }}"/>
			{!! $errors->first('creditcard.card_cvv', '<span class="invalid-feedback">:message</span>') !!}
		</div>
	</div>
</div>
<button id="submit-with-creditcard" type="button" class="btn btn-loading btn-custom btn-lg btn-block justify-content-center mb-3" data-loading-text="<i class='fas fa-spinner mr-2 spinner-rotate'></i> Processing Order">PLACE  ORDER</button>