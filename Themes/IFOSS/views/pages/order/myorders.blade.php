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
				<li class="breadcrumb-item"><a href="#">My account</a></li>
				<li class="breadcrumb-item active" aria-current="page">My orders</li>
			</ol>
		</nav>
		<div class="my-5">
			<div class="h6 font-weight-500 text-custom text-uppercase mb-4">Personal Information</div>
			<div class="flex-table table-s1 table-responsive-md">
				<div class="thead">
					@php
						$configThead = [
							[
								'name' => 'Order Id',
								'style' => 'min-width: 100px;'
							],
							[
								'name' => 'Payment Type',
								'style' => 'min-width: 100px;'
							],
							[
								'name' => 'Address',
								'style' => 'min-width: 200px;'
							],
							[
								'name' => 'Total',
								'style' => 'min-width: 100px;'
							],
							[
								'name' => 'Tracking Number',
								'style' => 'min-width: 165px;'
							],
							[
								'name' => 'Email',
							],
							[
								'name' => 'Status',
							],
							[
								'name' => 'Created Time',
								'style' => 'min-width: 140px;'
							]
						];
					@endphp
					@foreach($configThead as $thead)
						<div class="th" style="{{  $thead['style'] ?? '' }}">{{ $thead['name'] ?? '' }}</div>
					@endforeach
				</div>
				<div class="tbody">
					@foreach($myorders as $order)
						<div class="tr">
							<div class="tr">
								<div class="td">{{ $order->id }}</div>
								<div class="td">{{ ucfirst($order->payment_method) }}</div>
								<div class="td">{{ show_address_invoice($order) }}</div>
								<div class="td">$ {{ number_format($order->total_amount_order, 2, ',', '.') }}</div>
								<div class="td">
									@if($order->tracking_number)
										<a target="_blank" href="{{ generate_tracking_shipping_link($order->tracking_number) }}" class="text-blue">
											#{{ $order->tracking_number }}
										</a>
									@else
										<a href="javascript:void(0)" class="text-blue">
											NONE
										</a>
									@endif
								</div>
								<div class="td">{{ show_email_invoice($order) }}</div>
								<div class="td">{{ ucfirst(find_reference_by_id($order->status)->display_value) }}</div>
								<div class="td">{{ $order->created_at }}</div>
								<span class="td-action text-right">
									<a target="_blank" href="{{ route('public.order.detail', $order->id) }}" class="text-blue">View Detail</a>
								</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	
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