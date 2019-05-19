@extends("layouts.master")

@section('styles')
	<style type="text/css">
		body{ background-color: #f5f5f5;}
	</style>
@endsection

@section('content')
{!! Form::open([ 'autocomplete' => 'off']) !!}
	<div class="container">
		<div class="row justify-content-center my-5">
			<div class="col-md-6">
				<div class="panel">
					<div class="form-group-fl @if ($errors->has('email')) has-error @endif">
						<input value="{{ old('email') }}" readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="email" name="email" class="form-control-fl @if ($errors->has('email')) is-invalid @endif" placeholder="Email address" required />
						{!! $errors->first('email', '<span class="invalid-feedback">:message</span>') !!}
					</div>
					<div class="form-group-fl @if ($errors->has('username')) has-error @endif">
						<input value="{{ old('username') }}" readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="text" name="username" class="form-control-fl @if ($errors->has('username')) is-invalid @endif" placeholder="Username" required />
						{!! $errors->first('username', '<span class="invalid-feedback">:message</span>') !!}
					</div>

					<div class="form-group-fl @if ($errors->has('password')) has-error @endif">
						<input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="password" name="password" class="form-control-fl @if ($errors->has('password')) is-invalid @endif" placeholder="Create Password*" required/>
						{!! $errors->first('password', '<span class="invalid-feedback">:message</span>') !!}
					</div>
					<div class="form-group-fl">
						<input readonly onfocus="this.removeAttribute('readonly');" autocomplete="false" type="password" name="password_confirmation" class="form-control-fl" placeholder="Password Confirmation" required/>
					</div>
					<button type="submit" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">Create Account</button>
					<div class="gray-color">Have an Account? <a href="#">Sign in</a></div>
					<div class="text-center mt-3"><a href="#" class="text-underline">Privacy policy</a>  |  <a href="#" class="text-underline">Terms of use</a></div>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}
@endsection