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
                                                <a href="{{ generate_tracking_shipping_link($order->tracking_number) }}" target="_blank">
                                                    #{{ $order->tracking_number }}
                                                </a>
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
            <div class="col-md-3 right-sidebar order-status">
                @include('core-base::elements.forms.status', [ 'values' => $orderStatus ,'selected' => $order->status])
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
                                <!-- <div class="row">
                                    <div class="form-group col-sm-12 text-right">
                                        <button type="button" class="btn btn-outline-secondary round btn-min-width mr-1 mb-1 addProductDialog">Add Product</button>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="table-responsive col-sm-12">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>SKU</th>
                                              <th>Item name</th>
                                              <th class="text-right">Item price</th>
                                              <th class="text-right">Item quantity</th>
                                              <th class="text-right">Total</th>
                                              <!-- <th class="text-right">Action</th> -->
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @php
                                                $products = $order->products()->get();
                                            @endphp
                                            @foreach($products as $key => $product)
                                                <tr>
                                                  <th scope="row">#{{ $product->sku }}</th>
                                                  <td>
                                                    <p>{{ $product->name }}</p>
                                                  </td>
                                                  <td class="text-right">$ {{ number_format($product->price, 2, ',', '.') }}</td>
                                                  <td class="text-right">{{ $product->quantity }}</td>
                                                  <td class="text-right">$ {{ number_format($product->price * $product->quantity, 2, ',', '.') }}</td>
                                                  <!-- <td class="text-right">
                                                    <button type="button" class="btn-danger round deleteDialog tip" data-toggle="modal" data-section="{{ route('admin.order.product.delete', $product->id) }}">Remove</button>
                                                  </td> -->
                                                </tr>
                                            @endforeach
                                          </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    @if(!empty($order->payment_method))
                                        <div class="col-md-7 col-sm-12 text-center text-md-left">
                                            <p class="lead">Payment Methods:</p>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Method:</td>
                                                            <td>{{ $order->payment_method }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Paypal Id:</td>
                                                            <td>#{{ $order->paypal_id }}</td>
                                                        </tr>
                                                    </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        
                                    <div class="col-md-5 col-sm-12">
                                        <p class="lead">Total due</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                              <tbody>
                                                <tr>
                                                    <td>Coupon Code</td>
                                                    <td class="text-right">{{ $order->coupon_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Total</td>
                                                    <td class="text-right">$ {{ number_format($order->total_price, 2, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold-800">Total</td>
                                                    <td class="text-bold-800 text-right">$ {{ number_format($order->total_amount_order, 2, ',', '.') }}</td>
                                                </tr>
                                              </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="text-center">Address Shipping 
                                        </h5>
                                        @include('plugins-customer::partials.order_address',['addressKey' => 'address_shipping'])
                                    </div>

                                    <div class="col-md-6 tab-address-billing">
                                        <h5 class="text-center">Address Billing</h5>
                                        @include('plugins-customer::partials.order_address')
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
    <!-- Form modal tracking number -->
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

    <!-- Form modal product order -->
    <div id="add-product-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info white">
                        <h4 class="modal-title white" id="myModalLabel11"><i class="la la-tree"></i>{{ trans('Add Product') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss-modal="#add-product-modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {!! Form::open(['route' => ['admin.order.product.add', $order->id], 'id' => 'form-new-product-order']) !!}
                    <div class="modal-body with-padding">
                        <div class="form-group">
                            <label>{{ trans('Quantity') }}</label>
                            {!! Form::number('quantity', null, ['class' => 'form-control input-tracking-number']) !!}
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

        $(document).ready(function(){
            $('.tab-address-billing input, .tab-address-billing select').prop("disabled", true);
            $('.order-status select').prop("disabled", true);
        })
    </script>
    <script type="text/javascript">
        $(document).on('click', '.addProductDialog', function (event) {
            event.preventDefault();
            $('#form-new-product-order')[0].reset();
            $('#add-product-modal').modal('show');
        });

        $(document).on('click', '.deleteDialog', function (event) {
            event.preventDefault();

            $('#delete-crud-entry').data('section', $(this).data('section'));
            $('#delete-crud-modal').modal('show');
        });

        $('#delete-crud-entry').on('click', function (event) {
            event.preventDefault();
            $('#delete-crud-modal').modal('hide');

            let deleteURL = $(this).data('section');

            $.ajax({
                url: deleteURL,
                type: 'DELETE',
                success: function (data) {
                    if (data.error) {
                        Lcms.showNotice('error', data.message, Lcms.languages.notices_msg.error);
                    } else {
                        $('button[data-section="' + deleteURL + '"]').closest('tr').remove();
                        Lcms.showNotice('success', data.message, Lcms.languages.notices_msg.success);
                    }
                },
                error: function (data) {
                    Lcms.handleError(data);
                }
            });
        });
    </script>
@endsection