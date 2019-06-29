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
			<div class="mb-3">
				@php
					$orderStatus = find_reference_by_id($order->status)->value;
					$statusActive = [
						OrderReferenceConfig::REFERENCE_ORDER_STATUS_OPEN,
						OrderReferenceConfig::REFERENCE_ORDER_STATUS_SHIPPED,
						OrderReferenceConfig::REFERENCE_ORDER_STATUS_DELIVERED
					];	
					$write = true;			
				@endphp

				@if(in_array($orderStatus, $statusActive))
					<div class="progress-steps">
						@foreach($statusActive as $status)
							<div class="item @if($write) active @endif" >{{ $status }}
								<div class="progress-shape">
									<div class="dot"></div>
									<div class="line"></div>
								</div>
							</div>
							@if($orderStatus == $status)
								@php
									$write = false
								@endphp
							@endif
						@endforeach
					</div>
				@else
					<div class="progress-steps">
						<div class="item @if($write) active @endif" >{{ find_reference_by_id($order->status)->display_value }}
							<div class="progress-shape">
								<div class="dot"></div>
								<div class="line"></div>
							</div>
						</div>
					</div>
				@endif
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
									<td class="text-right">$ {{ number_format($product->price, 2, ',', '.') }}</td>
									<td class="text-right">{{ $product->quantity }}</td>
									<td class="text-right">$ {{ number_format($product->price * $product->quantity, 2, ',', '.') }}</td>
									<td>
										<a href="javascript:void(0)" class="send-email-product-order text-blue px-2" data-refund-url="{{ route('public.order.send_return_order', [ 'id' => $order->id, 'idProduct' => $product->product_id] ) }}">Return</a> 
										<a href="javascript:void(0)" class="send-email-product-order text-blue px-2" data-refund-url="{{ route('public.order.send_replace_order', [ 'id' => $order->id, 'idProduct' => $product->product_id]) }}">Replace</a> 
										<a href="javascript:void(0)" class="send-email-product-order px-2" data-refund-url="{{ route('public.order.send_cancel_order', [ 'id' => $order->id, 'idProduct' => $product->product_id]) }}">Cancel</a>
									</td>
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
	let sendEmailForProductOrder = function (url, reason){
		Lcms.beginLoading('#form-refund-order');
		$.ajax({
            url : url,
            type : "post",
            data : { _token : _token, reason: reason },
            success : function (data){
            	if(!data.error){
            		$('#refund-order-modal').modal('hide');
                	Lcms.showNotice('success', data.message, Lcms.languages.notices_msg.success);  
            	}
                else
                	Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
            },
            error: function(error) { // if error occured
                Lcms.showNotice('error', error.message || 'Cannot send email for this order.', Lcms.languages.notices_msg.error);  
            }
        }).done(function() {
			Lcms.endLoading('#form-refund-order');
		});
	}

	$(document).on('click', '.send-email-product-order', function (event) {
        event.preventDefault();
        let urlSendEmail = $(this).data('refund-url');
        $('#form-refund-order')[0].reset();
        $('#form-refund-order').attr('action', urlSendEmail);
        $('#refund-order-modal').modal('show');
    });


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
<script type="text/javascript">
	$(document).on('click', '#btn-send-refund', function(event){
	    event.preventDefault();
	    let reason = $('input[name="reason"]:checked').val();
	    if(!reason) return Lcms.showNotice('error', 'Please choose reason to send refund.', Lcms.languages.notices_msg.error);
	    var formAction = $("#form-refund-order").attr('action');
	    sendEmailForProductOrder(formAction, reason);
	});
</script>
	@include('pages.order.confirm-modal')
@endsection
