<div class="col-lg-4" style="margin-top: 66px;">
	<div class="cart-order-info font-weight-500">
		@foreach($cart['products'] as $productCartItem)
			@component("components.product-item-checkout-list")
				@slot("productItem", $productCartItem)
				@slot("quantities", $cart['quantities'])
			@endcomponent
		@endforeach
		<div class="list-item justify-content-start">
			Subtotal
			<span>${{ $cart['total_price'] }}</span>
		</div>
		<div class="list-item">
			Shipping fee
			<span>FREE</span>
		</div>
		<div class="list-item">
			Tax
			<span>0</span>
		</div>
		<hr>
		<div class="list-item">
			Total
			<span class="font-size-24">${{ $cart['total_price'] }}</span>
		</div>
		<div class="list-item">
			Your Save
			<span>${{ $cart['saved_price'] }}</span>
		</div>
	</div>

	<div class="cart-order-info font-weight-500 mb-0">
		<div class="text-uppercase mb-2">Coupon DISCOUNT</div>
		<div class="input-group mb-3">
			<input type="text" name="coupon_code" class="form-control rounded-0" placeholder="Enter your code here">
			<div class="input-group-append">
				<button class="btn btn-secondary rounded-0" type="button">apply</button>
			</div>
		</div>
	</div>
	<div class="coupon-calc">
		<div class="font-weight-500 mb-2">We offer free design for qualifying order over ${{ config('plugins-product.product.price_get_free_design_idea') }}</div>
		<div class="input-group mb-3" style="box-shadow: 0 4px 12px #d6e9e7;">
			<span type="text" class="wanting-price rounded-0 px-2 special-price">+  ${{ $cart['free_design']['wanting_price'] }}</span>
			<div class="input-group-append">
				<span class="input-group-text font-size-12 rounded-0" style="background-color: rgba(150,196,189,.2); color: #2a7469;">to qualify for {{ $cart['free_design']['total_free_design'] + 1 }} FREE DESIGN</span>
			</div>
		</div>
		<div class="text-center">
			<a href="#" class="text-blue text-uppercase text-underline">Learn more</a>
		</div>
	</div>
</div>