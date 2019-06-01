@extends('layouts.master')
@section('content')
    {!! Form::open(['route' => ['admin.customer.edit', $customer->id]]) !!}
        @php do_action(BASE_FILTER_BEFORE_RENDER_FORM, CUSTOMER_MODULE_SCREEN_NAME, request(), $customer) @endphp
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="from-actions-bottom-right">{{ trans('plugins-customer::customer.edit') }}</h4>
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
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-user-profile" data-toggle="tab" href="#user-profile" aria-controls="user-profile" aria-expanded="true">{{ __('Personal Info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-user-password" data-toggle="tab" href="#user-password" aria-controls="user-password" aria-expanded="false">{{ __('Change Password') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane active" id="user-profile" aria-labelledby="tab-user-profile" aria-expanded="true">
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="la la-eye"></i> About User</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('first_name')) has-error @endif">
                                                    <label for="userinput1">Fist Name</label>
                                                    {!! Form::text('first_name', $customer->first_name, ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'first name', 'data-counter' => 60]) !!}
                                                    {!! Form::error('first_name', $errors) !!}
                                                </div>
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('last_name')) has-error @endif">
                                                    <label for="userinput2">Last Name</label>
                                                    {!! Form::text('last_name', $customer->last_name, ['class' => 'form-control', 'id' => 'last_name', 'placeholder' => 'Smith', 'data-counter' => 60]) !!}
                                                    {!! Form::error('last_name', $errors) !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('username')) has-error @endif">
                                                    <label for="userinput3">Username</label>
                                                     {!! Form::text('username', $customer->username, ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username', 'data-counter' => 30]) !!}
                                                     {!! Form::error('username', $errors) !!}
                                                </div>
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('email')) has-error @endif">
                                                    <label for="userinput4">Email</label>
                                                    {!! Form::text('email', $customer->email, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'contact@example.com', 'data-counter' => 60]) !!}
                                                    {!! Form::error('email', $errors) !!}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('secondary_address')) has-error @endif">
                                                    <label for="userinput2">Secondary Address</label>
                                                    {!! Form::text('secondary_address', $customer->secondary_address, ['class' => 'form-control', 'id' => 'secondary_address', 'placeholder' => 'Address', 'data-counter' => 255]) !!}
                                                    {!! Form::error('secondary_address', $errors) !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('dob')) has-error @endif">
                                                    <label for="userinput3">Day of birth</label>
                                                     {!! Form::text('dob', $customer->dob, ['class' => 'form-control datepicker', 'id' => 'dob', 'placeholder' => '1993-03-23', 'data-counter' => 30]) !!}
                                                     {!! Form::error('dob', $errors) !!}
                                                </div>
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('job_position')) has-error @endif">
                                                    <label for="userinput4">Job</label>
                                                    {!! Form::text('job_position', $customer->job_position, ['class' => 'form-control', 'id' => 'job_position', 'placeholder' => 'PHP Developer', 'data-counter' => 255]) !!}
                                                    {!! Form::error('job_position', $errors) !!}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('phone')) has-error @endif">
                                                    <label for="userinput3">Phone</label>
                                                     {!! Form::text('phone', $customer->phone, ['class' => 'form-control us-phone-mask-input', 'id' => 'phone', 'data-counter' => 15, 'placeholder' => '(123) 456-7890']) !!}
                                                     {!! Form::error('phone', $errors) !!}
                                                </div>
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('secondary_phone')) has-error @endif">
                                                    <label for="userinput4">Secondary Phone</label>
                                                    {!! Form::text('secondary_phone', $customer->secondary_phone, ['class' => 'form-control us-phone-mask-input', 'id' => 'secondary_phone', 'data-counter' => 15, 'placeholder' => '(123) 456-7890']) !!}
                                                    {!! Form::error('secondary_phone', $errors) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="la la-eye"></i> Social media</h4>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2 @if ($errors->has('about')) has-error @endif">
                                                    <label for="userinput2">About</label>
                                                    {!! Form::textarea('about', $customer->about, ['class' => 'form-control', 'rows' => 3, 'id' => 'about', 'placeholder' => 'We are PHP Team!!!', 'data-counter' => 400]) !!}
                                                    {!! Form::error('about', $errors) !!}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('interest')) has-error @endif">
                                                    <label for="userinput1">Interest</label>
                                                    {!! Form::text('interest', $customer->interest, ['class' => 'form-control', 'id' => 'interest', 'placeholder' => 'Design, Web etc.', 'data-counter' => 255]) !!}
                                                    {!! Form::error('interest', $errors) !!}
                                                </div>
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('website')) has-error @endif">
                                                    <label for="userinput1">Website</label>
                                                    {!! Form::text('website', $customer->website, ['class' => 'form-control', 'id' => 'website', 'placeholder' => 'http://www.example.com', 'data-counter' => 255]) !!}
                                                    {!! Form::error('website', $errors) !!}
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('skype')) has-error @endif">
                                                    <label for="userinput3">Skype</label>
                                                     {!! Form::text('skype', $customer->skype, ['class' => 'form-control', 'id' => 'skype', 'data-counter' => 60, 'placeholder' => 'https://www.skype.com']) !!}
                                                     {!! Form::error('skype', $errors) !!}
                                                </div>
                                                <div class="form-group col-md-6 mb-2 @if ($errors->has('facebook')) has-error @endif">
                                                    <label for="userinput4">Facebook</label>
                                                    {!! Form::text('facebook', $customer->facebook, ['class' => 'form-control', 'id' => 'facebook', 'placeholder' => 'https://facebook.com', 'data-counter' => 255]) !!}
                                                    {!! Form::error('facebook', $errors) !!}
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="tab-pane" id="user-password" role="tabpanel" aria-labelledby="tab-user-password" aria-expanded="false">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 mb-2">
                                                <label for="userinput3">Change</label>
                                                 {!! Form::onOff('is_change_password',null, ['class' => 'form-control', 'id' => 'is_change_password']) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group hidden col-md-6 mb-2 @if ($errors->has('password')) has-error @endif">
                                                <label for="userinput3">Password</label>
                                                 {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'data-counter' => 60, 'placeholder' => 'password', 'autocomplete' => true]) !!}
                                                 <div class="pwstrength_viewport_progress"></div>
                                                 {!! Form::error('password', $errors) !!}
                                            </div>
                                            <div class="form-group hidden col-md-6 mb-2">
                                                <label for="userinput4">Re-type password</label>
                                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'data-counter' => 60, 'placeholder' => 're-type', 'autocomplete' => true]) !!}
                                                {!! Form::error('password_confirmation', $errors) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'advanced') @endphp
                </div>
            </div>
            <div class="col-md-3 right-sidebar">
                @include('core-base::elements.form-actions')
                @include('core-base::elements.forms.status', ['selected' => $customer->status])
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'top', $customer) @endphp
                @php do_action(BASE_ACTION_META_BOXES, CUSTOMER_MODULE_SCREEN_NAME, 'side', $customer) @endphp
            </div>
        </div>
    {!! Form::close() !!}
@stop

@section('master-footer')
    <script type="text/javascript">
        $(document).ready(() => {
            $(document).on('click', '#is_change_password', (event) => {
                if ($(event.currentTarget).is(':checked')) {
                    $('input[type=password]').closest('.form-group').removeClass('hidden').fadeIn();
                } else {
                    $('input[type=password]').closest('.form-group').addClass('hidden').fadeOut();
                }
            });
        });
    </script>
@stop