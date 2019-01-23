<div class="table-actions">

	<a href="{{ route($edit, $item->id) }}" class="btn btn-icon btn-pure success mr-1 tip" data-original-title="{{ __('Edit') }}">
		<i class="la la-pencil"></i>
	</a>

	<button type="button" class="btn btn-icon btn-pure danger mr-1 deleteDialog tip" data-toggle="modal" data-section="{{ route($delete, $item->id) }}" role="button" data-original-title="{{ __('Delete') }}">
		<i class="la la-archive"></i>
	</button>

</div>