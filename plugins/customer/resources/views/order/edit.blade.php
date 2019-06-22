@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.order.edit', $order->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, ORDER_MODULE_SCREEN_NAME, request(), $order) @endphp
        <div class="row">
            <div class="col-md-6 right-sidebar">
                <!-- Customer Order Information -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <span>Basic Information</span>
                        </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    </div>
                    <div class="card-content collpase show">
                            <div class="media">
                                <div class="media-body">
                                    <ul class="ml-2 px-0 list-unstyled">
                                        <li>Invoice Date : {{ $order->created_at }}</li>
                                        <li class="text-bold-800">Customer : {{ $order->customer->username }} - {{ $order->customer->email }}</li>
                                        <li>Tracking Number : 
                                            @if(!empty($order->tracking_number))
                                                #{{ $order->tracking_number }}
                                            @else
                                                <a href="javascript:void(0)" class="trackingNumberDialog">Add tracking number</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.forms.status', ['selected' => $order->status])
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-customer::order.edit') }}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('name')) has-error @endif">
                                        <label for="name">{{ trans('core-base::forms.name') }}</label>
                                        {!! Form::text('name', $order->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('core-base::forms.name_placeholder'), 'data-counter' => 120]) !!}
                                        {!! Form::error('name', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, ORDER_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            
        </div>
    {!! Form::close() !!}
    <!-- Form modal -->
    <div id="tracking-number-order-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info white">
                        <h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i>{{ trans('Add Tracking Number') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#tracking-number-order-modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['route' => ['admin.order.tracking_number', $order->id]]) !!}
                    <div class="modal-body with-padding">
                        <div class="form-group">
                            <label>{{ trans('Tracking Number') }}</label>
                            {!! Form::text('tracking_number', null, ['class' => 'form-control input-tracking-number']) !!}
                        </div>
                        <div class="form-actions text-right">
                            <button data-dismiss="modal"
                                    class="btn btn-light">{{ trans('core-base::system.user.cancel') }}</button>
                            <button type="submit" class="btn btn-info">{{ trans('Save') }}</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop

@section('master-footer')
    <script type="text/javascript">
        $(document).on('click', '.trackingNumberDialog', function (event) {
            event.preventDefault();
            $('.input-tracking-number').val("");
            $('#tracking-number-order-modal').modal('show');
        });
    </script>
@endsection