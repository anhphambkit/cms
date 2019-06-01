<div class="text-uppercase text-center mb-3 font-size-12 font-weight-500" style="color: #51887f;">Add Credit or Debit Card</div>
<div class="p-4 bg-white mb-3" style="border: 1px solid #96c4bd;">
	<div class="d-flex mb-2">
		<a href="#" class="btn-tab w-100 p-0 mr-2"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/visa-logo.png') }}" class="w-100"></a>
		<a href="#" class="btn-tab w-100 p-0 mr-2"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/mastercard-logo.png') }}" class="w-100"></a>
		<a href="#" class="btn-tab w-100 p-0 mr-2"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/amex-logo.png') }}" class="w-100"></a>
		<a href="#" class="btn-tab w-100 p-0"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/discover-logo.png') }}" class="w-100"></a>
	</div>
	<div class="form-group-fl">
		<input type="text" class="form-control-fl" placeholder="Name on card *">
	</div>
	<div class="form-group-fl">
		<input type="text" class="form-control-fl" placeholder="Card number *">
	</div>
	<div class="font-size-12 font-weight-500 my-4" style="color: #acacac;">Expiration date</div>
	<div class="row">
		<div class="col-md-4">
			<select class="form-control form-control-lg squared">
				<option>Month</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
		</div>
		<div class="col-md-4">
			<select class="form-control form-control-lg squared">
				<option>Year</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
			</select>
		</div>
		<div class="col-md-4">
			<input type="text" class="form-control form-control-lg squared" placeholder="CVV"/>
		</div>
	</div>
</div>
<button type="button" class="btn btn-custom btn-lg btn-block justify-content-center mb-3">PLACE  ORDER</button>