@extends("layouts.master")
@section('styles')
    <style type="text/css">
        body{ background-color: #f5f5f5;}
    </style>
@endsection

@section('content')

	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">My Cart</li>
			</ol>
		</nav>
	</div>
	{!! Form::open(['autocomplete' => 'off', 'id' => 'checkout-form']) !!}
	<section class="mb-5">
		<div class="product-cart">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<div class="mb-4">
							<div class="section-title mb-3">My Cart</div>
							<div class="mb-5">
								<div class="d-flex justify-content-between align-items-baseline mb-3">
									<div class="section-title-s3">your shipping details</div>
									<a href="#" class="text-custom d-inline-block"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/arrow-left.png') }}" class="mr-2">Return to cart</a>
								</div>
								@include('pages.checkout.addressShipping')
							</div>
							<div class="mb-5">
								<div class="section-title-s3 d-inline-block mb-3">your billing details</div>
								@include('pages.checkout.addressBilling')
							</div>
							<div class="mb-5">
								<div class="section-title-s3 d-inline-block mb-3">your payment info</div>
								<div class="row">
									<div class="col-md-9">
										<div class="text-uppercase text-center mb-3 font-size-12 font-weight-500" style="color: #51887f;">Check out with Paypal
										</div>
										<a href="#" id="submit-with-paypal" class="btn-tab"><img src="{{ URL::asset('themes/ifoss/assets/images/icons/paypal-logo.png') }}" alt=""></a>
										<div class="text-uppercase text-center my-3 font-size-12 font-weight-500">Or</div>
										@include('pages.checkout.creditCard')
									</div>
								</div>
							</div>
						</div>
					</div>
					@include('pages.checkout.sessionCheckout')
				</div>
			</div>
		</div>
	</section>
	{!! Form::close() !!}
@endsection

@section('variable-scripts')
	<script>
		const API = {
			ADD_COUPON_TO_CART : "{{ route('ajax.product.add_coupon') }}",
			DELETE_COUPON_IN_CART : "{{ route('ajax.product.delete_coupon') }}",
		};
	</script>
@stop
@section('master-footer')
	<script>
		const CHECKOUT_CREDIT_URL = "{{ route('public.product.checkout.credit') }}";

		$(document).ready(function() {
			$('#tab-card-type .btn-tab').on('click', function(event) {
				event.preventDefault();
				$('#tab-card-type .btn-tab').removeClass('active');
				$(this).addClass('active');
			});

			$('#submit-with-paypal').on('click', function(event) {
				event.preventDefault();
				$('#checkout-form').submit();
			});

			$('#submit-with-creditcard').on('click', function(event) {
				event.preventDefault();
				/* replace url post checkout*/
				$('#checkout-form').attr('action', CHECKOUT_CREDIT_URL);
				$('#checkout-form').submit();
			});

			$('#tab-card-type .btn-tab').on('click', function(event) {
				event.preventDefault();
				/* replace url post checkout*/
				let cardType = this.getAttribute('attr-name');
				$('input[name="creditcard[card_name]"]').val(cardType);
			});

			@if(setting('enable_test_paypal'))

				let configPaypal = {
					'card_name' : 'visa',
					'first_name' : 'Joe',
					'last_name' : 'Shopper',
					'card_number' : '4669424246660779',
					'expiration_month' : 11,
					'expiration_year' : 2019,
					'card_cvv' : '012',
				}

				Object.keys(configPaypal).forEach(function (key) {
				   // do something with obj[key]
				   	if(key == 'expiration_month' || key == 'expiration_year')
				   		$(`select[name="creditcard[${key}]"]`).val(configPaypal[key]);
				   	else
				   		$(`input[name="creditcard[${key}]"]`).val(configPaypal[key]);
				});

			@endif
		});
		

	</script>
@endsection