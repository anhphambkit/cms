@php
    $customerName = "";
    if($payment->customer) $customerName = $payment->customer->username;
@endphp
@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.payment.edit', $payment->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, PAYMENT_MODULE_SCREEN_NAME, request(), $payment) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-payment::payment.edit') }}</h4>
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
                                <h4 class="form-section"><i class="la la-eye"></i> Transaction # {{ $payment->paypal_id }}</h4>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('transaction_id')) has-error @endif">
                                        <label for="userinput1">Transaction ID</label>
                                        {!! Form::text('transaction_id', $payment->transaction_id, ['disabled' => 'disabled','class' => 'form-control', 'id' => 'transaction_id', 'placeholder' => 'Transaction ID', 'data-counter' => 60]) !!}
                                        {!! Form::error('transaction_id', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('payment_method')) has-error @endif">
                                        <label for="userinput2">Payment method</label>
                                        {!! Form::text('payment_method', $payment->payment_method, ['disabled' => 'disabled', 'class' => 'form-control', 'id' => 'payment_method', 'placeholder' => 'Payment method', 'data-counter' => 60]) !!}
                                        {!! Form::error('payment_method', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('currency')) has-error @endif">
                                        <label for="userinput3">Currency</label>
                                         {!! Form::text('currency', $payment->currency, ['disabled' => 'disabled', 'class' => 'form-control', 'id' => 'currency', 'placeholder' => 'Currency', 'data-counter' => 30]) !!}
                                         {!! Form::error('currency', $errors) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('amount')) has-error @endif">
                                        <label for="userinput4">Amount</label>
                                        {!! Form::text('amount', $payment->amount, ['disabled' => 'disabled', 'class' => 'form-control', 'id' => 'email', 'placeholder' => 'Amount', 'data-counter' => 60]) !!}
                                        {!! Form::error('amount', $errors) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('status')) has-error @endif">
                                        <label for="userinput2">Status</label>
                                        {!! Form::text('status', $payment->status, ['disabled' => 'disabled', 'class' => 'form-control', 'id' => 'status', 'placeholder' => 'Address', 'data-counter' => 255]) !!}
                                        {!! Form::error('status', $errors) !!}
                                    </div>

                                    <div class="form-group col-md-6 mb-2 @if ($errors->has('customer_id')) has-error @endif">
                                        <label for="userinput2">Customer</label>
                                        {!! Form::text('customer_id', $customerName, ['disabled' => 'disabled','class' => 'form-control', 'id' => 'customer_id', 'placeholder' => 'Customer', 'data-counter' => 255]) !!}
                                        {!! Form::error('customer_id', $errors) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-2 @if ($errors->has('description')) has-error @endif">
                                        <label for="userinput2">Description</label>
                                        {!! Form::textarea('description', $payment->description, ['disabled' => 'disabled', 'class' => 'form-control', 'rows' => 3, 'id' => 'description', 'placeholder' => 'We are PHP Team!!!', 'data-counter' => 400]) !!}
                                        {!! Form::error('description', $errors) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, PAYMENT_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @php do_action(BASE_ACTION_META_BOXES, PAYMENT_MODULE_SCREEN_NAME, 'top', $payment) @endphp
                @php do_action(BASE_ACTION_META_BOXES, PAYMENT_MODULE_SCREEN_NAME, 'side', $payment) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop