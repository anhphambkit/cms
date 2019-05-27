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
					<?php 
					function setTheadWidth($key){
						if($key == 0){ 
							echo 'style="min-width: 100px;"';
						}
						else if($key == 2){ 
							echo 'style="min-width: 110px;"';
						}
						else if($key == 1 || $key == 8){ 
							echo 'style="min-width: 140px;"';
						}
						else if($key == 5){ 
							echo 'style="min-width: 165px;"';
						}
					}
					$thead = array('Order Id', 'Payment Type','Full Name', 'Address', 'Total', 'Tracking Number', 'Email','Status', 'Created Time'); 
					foreach ($thead as $key => $value) { ?>
						<div class="th" <?php setTheadWidth($key); ?> ><?php echo $value; ?></div>
					<?php } ?>
				</div>
				<div class="tbody">
					<?php for ($i=0; $i < 3; $i++) { ?>
						<div class="tr">
							<!-- <?php $tbody = array('11065', 'Credit Card','Amber Steel', '40 5th Ave New York, NY 10011, 9177440706', '$138.60', '709709LS46VHA', 'amber.steel@me.com','Shipped', '2019 -04-19  08:56:57'); ?> -->
							<div class="tr">
								<div class="td">11065</div>
								<div class="td">Credit Card</div>
								<div class="td">Amber Steel</div>
								<div class="td">40 5th Ave New York, NY 10011, 9177440706</div>
								<div class="td">$138.60</div>
								<div class="td"><a href="#" class="text-blue">709709LS46VHA</a></div>
								<div class="td">amber.steel@me.com</div>
								<div class="td">Shipped</div>
								<div class="td">2019 -04-19  08:56:57</div>
								<span class="td-action text-right">
									<a href="#" class="text-blue">View Detail</a>
									<a href="#" class="text-blue">Issue a refund</a>
									<a href="#" class="text-yellow" data-toggle="modal" data-target="#resend-confirmation-order">Ressend Comfirmation Order</a>
								</span>
							</div>
						</div>
					<?php } ?>
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