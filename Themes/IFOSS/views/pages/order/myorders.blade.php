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
									<a target="_blank" href="{{ route('public.order.detail', $order->id) }}" class="text-blue">View Detail</a>
									{!! view('pages.order.refund-modal', ['item' => $order])->render() !!}
									<a href="javascript:void(0)" class="text-yellow" onclick="resendConfirmation({{ $order->id}})">Ressend Comfirmation Order</a>
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

		let resendConfirmation = function (id){
			$.ajax({
                url : "{{ route('public.order.resend_confirmation') }}",
                type : "post",
                data : {
                    _token : _token,
                    id : id
                },
                success : function (data){
                    Lcms.showNotice('success', 'Resend Confirmation success.', Lcms.languages.notices_msg.success);  
                },
                error: function(error) { // if error occured
                    Lcms.showNotice('error', 'Cannot Resend Confirmation for this order.', Lcms.languages.notices_msg.error);  
                }
            });
		}

	</script>
	<script type="text/javascript">
        $(document).on('click', '.sendRefundDialog', function (event) {
            event.preventDefault();
            $('#form-refund-order')[0].reset();
            $('#form-refund-order').attr('action', $(this).data('refund-url'));
            $('#refund-order-modal').modal('show');
        });
    </script>
    
    @include('pages.order.confirm-modal')
@endsection