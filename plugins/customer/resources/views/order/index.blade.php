@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        @include('core-base::elements.tables.datatables', ['title' => trans('plugins-customer::order.list'), 'dataTable' => $dataTable ])
    </div>

    <!-- Form modal -->
    <div id="refund-order-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info white">
                    	<h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i>{{ trans('Refund order') }}</h4>
			            <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#refund-order-modal">
			                <span aria-hidden="true">&times;</span>
			            </button>
                    </div>

                    {!! Form::open(['id' => 'form-refund-order']) !!}
                    <div class="modal-body with-padding">
                        <div class="form-group">
                            <label>{{ trans('Amount') }}</label>
                            {!! Form::number('amount', null, ['class' => 'form-control input-amount-refund']) !!}
                        </div>
                        <div class="form-actions text-right">
                            <button data-dismiss="modal"
                                    class="btn btn-light">{{ trans('core-base::system.user.cancel') }}</button>
                            <button type="submit" class="btn btn-info">{{ trans('Refund') }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /form modal -->
</div>
@endsection
@section('master-footer')
    <script type="text/javascript">
        $(document).on('click', '.refundDialog', function (event) {
            event.preventDefault();
            $('.input-amount-refund').val("");
            $('#form-refund-order').attr('action', $(this).data('refund-url'));
            $('#refund-order-modal').modal('show');
        });
    </script>
@endsection