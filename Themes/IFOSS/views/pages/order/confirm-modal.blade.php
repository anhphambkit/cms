@php
	$iconClose = asset('themes/ifoss/assets/images/icons/close.png');
	$reasons = array('No longer needed', 'Item defective', 'Wrong item was sent');
@endphp
<!-- Modal -->
<div class="modal fade" id="refund-order-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header border-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><img src="{{ $iconClose }}" alt=""></span>
				</button>
			</div>
			{!! Form::open(['id' => 'form-refund-order']) !!}
			<div class="modal-body px-s1">
				<div class="text-uppercase text-custom mb-3">return reason</div>
				<div class="mb-3">
					@foreach($reasons as $key => $reason)
						<div class="form-group">
							<div class="radio radio-custom pl-2">
								<input id="radio-{{ $key }}" type="radio" name="reason" value="{{ $reason }}"/>
								<label for="radio-{{ $key }}">{{ $reason }}</label>
							</div>
						</div>
					@endforeach
				</div>
				<button type="button" id="btn-send-refund" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">Submit</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('click', '#btn-send-refund', function(event){
	    event.preventDefault();
	    let reason = $('input[name="reason"]:checked').val();
	    if(!reason)
	    	return Lcms.showNotice('error', 'Please choose reason to send refund.', Lcms.languages.notices_msg.error);
	    $('#form-refund-order').submit();
	});
</script>