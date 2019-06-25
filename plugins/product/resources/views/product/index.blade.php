@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        @include('core-base::elements.tables.datatables', ['title' => trans('plugins-product::product.list'), 'dataTable' => $dataTable ])
    </div>

    <!-- Form modal -->
    <div id="import_inventory" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info white">
                    	<h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i>{{ trans('Import inventory') }}</h4>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#import_inventory">
			                <span aria-hidden="true">&times;</span>
			            </button>
                    </div>
                    {!! Form::open(['enctype' => 'multipart/form-data','id' => 'form-import-inventory', 'route' => ['admin.product.inventory.import']]) !!}
                    <div class="modal-body with-padding">
                        <div class="form-group">
                            <label>{{ trans('File csv') }}</label>
                            {!! Form::file('csv', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-actions text-right">
                            <button data-dismiss="modal"
                                    class="btn btn-light">{{ trans('core-base::system.user.cancel') }}</button>
                            <button type="submit" class="btn btn-info">{{ trans('Import') }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('master-footer')
    <script type="text/javascript">
        $('#import_inventory').on('shown.bs.modal', function (e) {
          // do something...
          $('#form-import-inventory')[0].reset();
        })
    </script>
@endsection