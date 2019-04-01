@extends('bases::layouts.master')
@section('content')
    {!! Form::open(['route' => ['productlookbook.edit', $productlookbook->id]]) !!}
        @php do_action(BASE_ACTION_EDIT_CONTENT_NOTIFICATION, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, request(), $productlookbook) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="main-form">
                    <div class="form-body">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name" class="control-label required">{{ trans('bases::forms.name') }}</label>
                            {!! Form::text('name', $productlookbook->name, ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('bases::forms.name_placeholder'), 'data-counter' => 120]) !!}
                            {!! Form::error('name', $errors) !!}
                        </div>
                    </div>
                </div>
                @php do_action(BASE_ACTION_META_BOXES, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, 'advanced', $productlookbook) @endphp
            </div>
            <div class="col-md-3 right-sidebar">
                @include('bases::elements.form-actions')
                @include('bases::elements.forms.status', ['selected' => $productlookbook->status])
                @php do_action(BASE_ACTION_META_BOXES, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, 'top', $productlookbook) @endphp
                @php do_action(BASE_ACTION_META_BOXES, PRODUCTLOOKBOOK_MODULE_SCREEN_NAME, 'side', $productlookbook) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop
