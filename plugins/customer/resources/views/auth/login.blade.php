@extends("layouts.master")

@section('styles')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <style type="text/css">
        body{ background-color: #f5f5f5;}
    </style>
@endsection

@section('master-footer')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@endsection

@section('content')
{!! Form::open(['route' => 'public.customer.login', 'method' => 'post', 'autocomplete' => 'off']) !!}
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <div class="panel">
                    <div class="form-group-fl">
                        <input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="email" class="form-control-fl" placeholder="Email address*" name="email" maxlength="100" required/>
                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group-fl">
                        <input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="password" class="form-control-fl" placeholder="Password*" id="password" name="password" required/>
                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-custom checkbox-circle">
                            <input id="checkbox-circle-circle" type="checkbox" checked="" name="remember"/>
                            <label for="checkbox-circle-circle">Remember Me</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">
                        Sign in
                    </button>
                    <div class="gray-color">or <a href="{{ route('public.customer.create-account') }}">Create a New Account</a>  |  <a href="#">Forgot Password?</a></div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection
