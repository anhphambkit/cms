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
				@php
					$menuItems = array('My account','My orders', 'View detail');
				@endphp
				@foreach($menuItems as $item)
					<li class="breadcrumb-item"><a href="#">{{ $item }}</a></li>
				@endforeach
				<li class="breadcrumb-item active" aria-current="page">Order Id : {{ $order->id }}</li>
			</ol>
		</nav>
		<div class="my-5">
			<div class="d-sm-flex justify-content-between mb-3">
				<div class="h6 font-weight-500 text-custom text-uppercase mb-4">Personal Information</div>
				<span>Placed on <b>{{ $order->created_at }}</b></span>
			</div>
			<div class="mb-3">
				<div class="progress-steps">
					<div class="item active">PAID
						<div class="progress-shape">
							<div class="dot"></div>
							<div class="line"></div>
						</div>
					</div>
					<div class="item">SHIPPED
						<div class="progress-shape">
							<div class="dot"></div>
							<div class="line"></div>
						</div>
					</div>
					<div class="item">DELIVERED
						<div class="progress-shape">
							<div class="dot"></div>
							<div class="line"></div>
						</div>
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
							<b>{{ $shippingInfo->first_name ?? ''}} {{ $shippingInfo->last_name }}</b> <br>
							{{ $shippingInfo->address_1 ?? ''}} <br>
							@if($shippingInfo->address_2 ?? false)
								{{ $shippingInfo->address_2 }} <br>
							@endif
							{{ $shippingInfo->city ?? ''}} {{ $shippingInfo->zip ?? ''}} <br>
							Phone : {{ $shippingInfo->phone_number }}
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
							<b>{{ $billingInfo->first_name ?? ''}} {{ $billingInfo->last_name }}</b> <br>
							{{ $billingInfo->address_1 ?? ''}} <br>
							@if($billingInfo->address_2 ?? false)
								{{ $billingInfo->address_2 }} <br>
							@endif
							{{ $billingInfo->city ?? ''}} {{ $billingInfo->zip ?? ''}} <br>
							Phone : {{ $billingInfo->phone_number }}
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
							@php
								$theads = array('SKU','Item name','Item price','Item quantity','Total', 'Actions'); 
							@endphp
							@foreach($theads as $key => $item)
								<th class="th" @if($key == 1) style="width: 230px;" @endif>{{ $item }}</th>
							@endforeach
						</thead>
						<tbody class="tbody">
							@php
								$products = $order->products()->get();
							@endphp
							@foreach($products as $key => $product)
								<tr class="tr">
									<td>{{ $product->sku }}</td>
									<td>{{ $product->name }}</td>
									<td class="text-right">${{ number_format($product->price, 2, ',', '.') }}</td>
									<td class="text-right">{{ $product->quantity }}</td>
									<td class="text-right">${{ number_format($product->price * $product->quantity, 2, ',', '.') }}</td>
									<td><a href="" class="text-blue px-2">Return</a> <a href="" class="text-blue px-2">Replace</a> <a href="" class="px-2">Cancel</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="col-lg-3" >
					<div class="cart-order-info font-weight-500 p-0">
						<div class="list-item">
							Subtotal
							<span>$125.64</span>
						</div>
						<div class="list-item">
							Discount
							<span>-$0.00</span>
						</div>
						<div class="list-item">
							Tax (7.5%)
							<span>-$13.20</span>
						</div>
						<hr>
						<div class="list-item">
							Total
							<span class="font-size-24">$135.06</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	@include('pages.order.confirm-modal')
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
