@php
	$titleEdit = $titleEdit ?? trans('core-base::forms.edit-item');
	$titleRemove = $titleRemove ?? trans('core-base::forms.delete');
@endphp
<span class="dropdown table-actions">
    <button id="table-actions-{{ $item->id }}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="btn btn-primary dropdown-toggle dropdown-menu-right"><i class="ft-settings"></i></button>
    <span aria-labelledby="table-actions-{{ $item->id }}" class="dropdown-menu mt-1 dropdown-menu-right">
        <a href="{{ route($edit, $item->id) }}" class="dropdown-item"><i class="la la-eye"></i> {{ $titleEdit }}</a>
        <a href="javascript:void(0)" class="dropdown-item deleteDialog tip" data-toggle="modal" data-section="{{ route($delete, $item->id) }}"><i class="la la-trash"></i> {{ $titleRemove }}</a>
        @if(!empty($appendActions))
        	{!! $appendActions !!}
        @endif
    </span>
</span>