@extends("layouts.master")

@section('styles')
    <style type="text/css">
        body{ background-color: #f5f5f5;}
    </style>
@endsection

@section('content')
{!! Form::open(['autocomplete' => 'off']) !!}
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">My account</a></li>
                <li class="breadcrumb-item active" aria-current="page">My profile</li>
            </ol>
        </nav>

        <div class="row justify-content-center my-5">
            <div class="col-lg-8">
                <div class="panel">
                    <div class="h6 font-weight-500 text-custom text-uppercase mb-4">Personal Information</div>
                    <div class="form-group form-group-s1">
                        <label>Account Name</label>
                        <div class="input-icon align-right">
                            <i class="far fa-edit icon"></i>
                            <input type="text" class="form-control form-control-lg squared" value="{{ $currentAccount->username }}" name="username"/>
                        </div>
                    </div>
                    <div class="form-group form-group-s1">
                        <label>Email Address</label>
                        <input type="text" class="form-control form-control-lg squared" value="{{ $currentAccount->email }}" name="email"/>
                    </div>
                    <div class="form-group form-group-s1">
                        <label>Change Password</label>
                        <div class="input-icon align-right">
                            <input type="password" class="form-control form-control-lg squared mb-3" placeholder="Current password" name="current_password"/>
                            <div class="input-tip">At least 6 characters</div>
                        </div>
                        <input type="password" class="form-control form-control-lg squared mb-3" placeholder="New password" name="password"/>
                        <input type="password" class="form-control form-control-lg squared mb-3" placeholder="Verify new password" name="password_confirmation"/>
                    </div>
                </div>

                <div class="panel">
                    <div class="h6 font-weight-500 text-custom text-uppercase mb-4">Add / Edit an Address</div>
                    @include("plugins-customer::partials.template_address_attributes")
                    <div class="group-address">
                        @php
                            $addressAttributes = json_decode($currentAccount->address);
                        @endphp

                        @if($addressAttributes)
                            @foreach($addressAttributes as $key => $address)
                                @include("plugins-customer::partials.address_attributes",['key' => $key, 'address' => $address])
                            @endforeach
                        @endif
                    </div>
                    <a href="javascript:void(0)" class="btn-add-address text-blue text-uppercase text-underline d-inline-block my-3">+ Add an address</a>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">Save</button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="cancel-btn btn btn-outline-custom btn-s2 btn-block justify-content-center mb-3">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@endsection

@section('master-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.11/handlebars.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            const source = document.getElementById("attribute-address-template").innerHTML
            const template = Handlebars.compile (source);
            $('.btn-add-address').on('click', function(event) {
                event.preventDefault();
                const attr_item_template = template({key: Date.now()})
                $('.group-address').append(attr_item_template);
            });

            $(document).on('click', '.attr-item-drop', function(event){
                event.preventDefault();
                $(this).closest('.attribute-item').remove()
            });
            
            $(document).on('click', '.cancel-btn', function(event){
                event.preventDefault();
                window.location.href = "{{ route('homepage') }}"
            });

            if($('.group-address').text().trim() == ""){
                $('.btn-add-address').trigger('click');
            }

            $(document).on('change', '.is_default_shipping', function(event){
                if (event.target.checked) {
                    $('.is_default_shipping').not(this).prop('checked', false);
                }
            });

            $(document).on('change', '.is_default_billing', function(event){
                if (event.target.checked) {
                    $('.is_default_billing').not(this).prop('checked', false);
                }
            });

            $(document).on('change', '.address-type', function(event){
                if (event.target.checked) {
                    var elements = $(this).closest(".section-address").find('.address-type');
                    elements.not(this).prop('checked', false)
                }
            });
        })


    </script>
@endsection


