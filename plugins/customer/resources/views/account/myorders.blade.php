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
								<div class="td"><a href="#" class="text-blue">{{ $order->tracking_number ?? 'NONE' }}</a></div>
								<div class="td">{{ show_email_invoice($order) }}</div>
								<div class="td">{{ ucfirst(find_reference_by_id($order->status)->value) }}</div>
								<div class="td">{{ $order->created_at }}</div>
								<span class="td-action text-right">
									<a href="#" class="text-blue">View Detail</a>
									<a href="#" class="text-blue">Issue a refund</a>
									<a href="#" class="text-yellow" data-toggle="modal" data-target="#resend-confirmation-order">Ressend Comfirmation Order</a>
								</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
<div class="modal fade" id="resend-confirmation-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header border-0">
				<!-- <h5 class="modal-title text-uppercase text-custom" id="exampleModalLabel">return reason</h5> -->
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><img src="assets/images/icons/close.png" alt=""></span>
				</button>
			</div>
			<div class="modal-body px-s1">
				<div class="text-uppercase text-custom mb-3">return reason</div>
				<div class="mb-3">
					<?php $checkboxList = array('No longer needed', 'Item defective', 'Wrong item was sent'); 
					foreach ($checkboxList as $key => $value) { ?>
						<div class="form-group">
							<div class="radio radio-custom pl-2">
								<input id="radio-<?php echo $key; ?>" type="radio" name="radio-list"/>
								<label for="radio-<?php echo $key; ?>"><?php echo $value; ?></label>
							</div>
						</div>
					<?php } ?>
				</div>
				<button type="button" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">Submit</button>
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