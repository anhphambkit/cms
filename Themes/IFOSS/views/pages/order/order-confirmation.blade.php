@php
	use Plugins\Customer\Contracts\OrderReferenceConfig;
@endphp

@extends("layouts.master")
@section('styles')
@endsection
@section('content')
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				@php
					$menuItems = array('My account','My orders');
				@endphp
				@foreach($menuItems as $item)
					<li class="breadcrumb-item"><a href="#">{{ $item }}</a></li>
				@endforeach
				<li class="breadcrumb-item active" aria-current="page">Order Id - #{{ $order->id }}</li>
			</ol>
		</nav>
		<div class="my-5">
			<div class="d-sm-flex justify-content-between mb-3">
				<div class="h6 font-weight-500 text-custom text-uppercase mb-4">Personal Information</div>
				<span>Placed on <b>{{ $order->created_at }}</b></span>
			</div>
			<div class="mb-4">
				<div class="alert alert-success" role="alert">
					<div class="alert-icon">
						<i class="fas fa-clipboard-check"></i>
					</div>
					<div>
						<div class="h5 mb-1">Your products successfully paid!</div>
						Please remember to tracking the orders 
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-6">
					<div class="panel-s1">
						<div class="panel-title">Shipping Address</div>
						<div class="panel-content">
							@php
								$shippingInfo = json_decode($order->address_shipping);
							@endphp
							<b>{{ $shippingInfo->first_name ?? ''}} {{ $shippingInfo->last_name ?? '' }}</b> <br>
							{{ $shippingInfo->address_1 ?? ''}} <br>
							@if($shippingInfo->address_2 ?? false)
								{{ $shippingInfo->address_2 }} <br>
							@endif
							{{ $shippingInfo->city ?? ''}} {{ $shippingInfo->zip ?? ''}} <br>
							Phone : {{ $shippingInfo->phone_number ?? '' }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel-s1">
						<div class="panel-title">Billing Address</div>
						<div class="panel-content">
							@php
								$billingInfo = json_decode($order->address_billing);
							@endphp
							<b>{{ $billingInfo->first_name ?? ''}} {{ $billingInfo->last_name ?? '' }}</b> <br>
							{{ $billingInfo->address_1 ?? ''}} <br>
							@if($billingInfo->address_2 ?? false)
								{{ $billingInfo->address_2 }} <br>
							@endif
							{{ $billingInfo->city ?? ''}} {{ $billingInfo->zip ?? ''}} <br>
							Phone : {{ $billingInfo->phone_number ?? '' }}
						</div>
					</div>
				</div>
			</div>
			<div class="mb-3">
				<div class="panel-s1">
					<div class="panel-title text-center">ORDER SUMMARY</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-9">
					<table class="table pure-table-s1 table-responsive-md">
						<thead class="thead">
							<th class="th">SKU</th>
							<th class="th" style="max-width: 200px;">Name</th>
							<th class="th">Price</th>
							<th class="th">Quantity</th>
							<th class="th">Total</th>
						</thead>
						<tbody class="tbody">
							@php
								$products = $order->products()->get();
							@endphp
							@foreach($products as $key => $product)
								<tr class="tr">
									<td>{{ $product->sku }}</td>
									<td>{{ $product->name }}</td>
									<td class="text-right">$ {{ number_format($product->price, 2, ',', '.') }}</td>
									<td class="text-right">{{ $product->quantity }}</td>
									<td class="text-right">$ {{ number_format($product->price * $product->quantity, 2, ',', '.') }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="col-lg-3" >
					<div class="cart-order-info font-weight-500 p-0">
						<div class="list-item">
							Subtotal
							<span>${{ number_format($order->total_price, 2, ',', '.') }}</span>
						</div>
						<div class="list-item">
							Discount
							<span>${{ number_format($order->discount_price, 2, ',', '.') }}</span>
						</div>
						<hr>
						<div class="list-item">
							Total
							<span class="font-size-24">${{ number_format($order->total_amount_order, 2, ',', '.') }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('master-footer')
<script>
	$(document).ready(function() {
		var tbodyWidth = [];
		$('.flex-table .thead .th').each(function(index, el) {
			var data = $(el).css('width');
			tbodyWidth.push(parseInt(data));
		});
		$('.flex-table .tbody .tr').each(function(index, el) {
			$(el).find('.td').each(function(index, el) {
				$(el).css('min-width', tbodyWidth[index] + 'px');
			});
		});
	});
</script>
@endsection
