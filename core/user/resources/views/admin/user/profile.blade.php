@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12 crop-avatar">
		<div class="row match-height">
			<div class="col-lg-4 col-md-4 col-sm-12 ">
				<div class="card">
					<div class="card-body text-center mt-element-card mt-card-round mt-element-overlay">
                        <div class="profile-userpic mt-card-item">
                            <div class="avatar-view mt-card-avatar mt-overlay-1">
                                <img src="{{ url($user->getProfileImage()) }}" class="img-responsive" alt="avatar" h>
                                <div class="mt-overlay">
                                    <ul class="mt-info">
                                        <li>
                                            <a class="btn default btn-outline" href="javascript:;">
                                            	<i class="far fa-edit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                            	<h3 class="mt-card-name">{{ $user->getFullName() }}</h3>
                                <p class="mt-card-desc font-grey-mint">{{ $user->job_position }}</p>
							    <div class="text-center">
							        <a href="{{ $user->facebook }}" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="la la-facebook"></span></a>
							        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="la la-twitter"></span></a>
							        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span class="la la-linkedin font-medium-4"></span></a>
							        <a href="{{ $user->github }}" class="btn btn-social-icon mr-1 mb-1 btn-outline-github"><span class="la la-github font-medium-4"></span></a>
							    </div>
							</div>
                        </div>
					</div>
				</div>
			</div>

			@include("core-user::partials.cropper-modal")
		</div>
	</div>
</div>
@stop
