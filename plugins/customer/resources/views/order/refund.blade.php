<div class="table-actions row">
	<button type="button" class="btn btn-icon btn-pure danger mr-1 refundDialog tip" data-toggle="modal" data-refund-url="{{ route('public.product.order.refund', $item->id) }}" role="button" data-original-title="{{ __('Refund') }}">
		<i class="fas fa-undo-alt"></i>
	</button>
</div>