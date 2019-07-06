<div class="col-lg-4 cart-info-total" style="margin-top: 66px;">
	<div class="cart-order-info font-weight-500">
		@foreach($cart['products'] as $productCartItem)
			@component("components.product-item-checkout-list")
				@slot("productItem", $productCartItem)
				@slot("quantities", $cart['quantities'])
			@endcomponent
		@endforeach
			<div class="list-item">
				Subtotal
				<span class="sub-total-cart">${{ number_format($cart['sub_total']) }}</span>
			</div>
			<div class="list-item">
				Shipping fee
				<span>FREE</span>
			</div>
			<div class="list-item">
				Discount
				<span class="discount-price">-${{ number_format($cart['coupon_discount_amount']) }}</span>
			</div>
			<div class="list-item">
				Tax
				<span>$0</span>
			</div>
			<hr>
			<div class="list-item">
				Total
				<span class="font-size-24 total-price-cart">${{ number_format($cart['total_price']) }}</span>
			</div>
			<div class="list-item">
				Your Save
				<span class="saved-price-cart">${{ number_format($cart['saved_price']) }}</span>
			</div>
	</div>

	<div class="cart-order-info font-weight-500 mb-0">
		<div class="text-uppercase mb-2">Coupon DISCOUNT</div>
		<div class="input-group mb-3 coupon-form">
			<input type="text" class="form-control rounded-0 coupon_code" placeholder="Enter your code here" id="coupon_code" name="coupon_code">
			<div class="input-group-append">
				<button class="btn btn-secondary rounded-0 add-coupon-btn" id="add-coupon-btn" type="button">apply</button>
			</div>
		</div>
		<div class="coupon-in-use">
			@if($cart['coupon'])
				<div class="row coupon-{{ $cart['coupon']->id }}">
					<div class="text-uppercase mb-2 col-md-8 coupon-code-text">{{ $cart['coupon']->code }}</div>
					<div class="text-uppercase mb-2 col-md-4">
						<a class="action-delete-coupon delete-coupon-{{ $cart['coupon']->id }}" data-coupon-id="{{ $cart['coupon']->id }}">
							<i class="far fa-trash-alt icon-action-delete-coupon"></i>
							{{ trans('core-base::forms.delete') }}
						</a>
					</div>
				</div>
			@endif
		</div>
	</div>
	<div class="coupon-calc">
		<div class="font-weight-500 mb-2">We offer free design for qualifying order over ${{ config('plugins-product.product.price_get_free_design_idea') }}</div>
		<div class="input-group mb-3" style="box-shadow: 0 4px 12px #d6e9e7;">
			<span type="text" class="wanting-price rounded-0 px-2 special-price">+  ${{ number_format($cart['free_design']['wanting_price']) }}</span>
			<div class="input-group-append">
				<span class="input-group-text font-size-12 rounded-0 total-free-designs-cart" style="background-color: rgba(150,196,189,.2); color: #2a7469;">to qualify for {{ $cart['free_design']['total_free_design'] + 1 }} FREE DESIGN</span>
			</div>
		</div>
		<div class="text-center">
			<a href="#" class="text-blue text-uppercase text-underline">Learn more</a>
		</div>
	</div>
</div>