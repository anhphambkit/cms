@php
	$iconClose = asset('themes/ifoss/assets/images/icons/close.png');
@endphp
<!-- Modal -->
<div class="modal fade" id="resend-confirmation-order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header border-0">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><img src="{{ $iconClose }}" alt=""></span>
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