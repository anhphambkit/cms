<div class="table-actions row">
	<button type="button" class="btn btn-icon btn-pure danger mr-1 refundDialog tip" data-toggle="modal" data-refund-url="{{ route('public.product.order.refund', $item->id) }}" role="button" data-original-title="{{ __('Refund') }}">
		<i class="fas fa-undo-alt"></i>
	</button>

	<button type="button" class="btn btn-icon btn-pure danger mr-1 confirmOrder tip" data-refund-url="{{ route('admin.order.resend_confirmation', $item->id) }}" role="button" data-original-title="{{ __('Send Confirm Order') }}">
		<i class="fas fa-clipboard-check"></i>
	</button>
</div>