<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="{{ app()->getLocale() }}"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="{{ app()->getLocale() }}"><![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="{{ app()->getLocale() }}"><![endif]-->
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {!! SeoHelper::render() !!}
        <meta name="format-detection" content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Fonts-->
        <link href="https://fonts.googleapis.com/css?family={{ theme_option('primary_font', 'Roboto') }}" rel="stylesheet" type="text/css">
        <!-- CSS Library-->
        @foreach($cssFiles as $css)
            <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset($css) }}">
        @endforeach

        @section('styles')
        @show
        <style>
            a.menu-link-custom {
                color: inherit;
                transition: unset;
                text-decoration: unset;
            }
            .badge-3d-custom {
                position: absolute;
                bottom: 10px;
                right: 10px;
                z-index: 9;
            }
        </style>

        @section('master-head')
        @show
        <!--HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
        <!--WARNING: Respond.js doesn't work if you view the page via file://-->
        <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <!--[if IE 7]><body class="ie7 lt-ie8 lt-ie9 lt-ie10"><![endif]-->
    <!--[if IE 8]><body class="ie8 lt-ie9 lt-ie10"><![endif]-->
    <!--[if IE 9]><body class="ie9 lt-ie10"><![endif]-->
    <body class="@yield('body-class') id="@yield('body-id', 'module')"  data-img-loading="@yield('loading-img', URL::asset('favicon.png'))">
        @include("partials.header")

        @section('content')
        @show

        <div class="ajax-load text-center" style="display:none">
            <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
        </div>

        @include("partials.footer")
        
        @foreach($jsFiles as $js)
            <script src="{{ URL::asset($js) }}" type="text/javascript"></script>
        @endforeach
        @include('core-base::elements.common')
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @section('script-table')
        @show
        <!-- ========== START PAGE SCRIPTS ========== -->
        <script>
            const API_SHOP = {
                ADD_TO_CART : "{{ route('ajax.product.add_to_cart') }}",
                UPDATE_PRODUCT_IN_CART : "{{ route('ajax.cart.update_product_in_cart') }}",
                {{--VIEW_CART_HEADER : "{{ route('ajax.shop.view_cart_header') }}",--}}
                DELETE_PRODUCT_IN_CART : "{{ route('ajax.cart.delete_product_in_cart') }}",
                ADD_COUPON_TO_CART : "{{ route('ajax.product.add_coupon') }}",
                DELETE_COUPON_IN_CART : "{{ route('ajax.product.delete_coupon') }}",
            };

            const PRODUCT = {
                GET_OVERVIEW_INFO_POPUP : "{{ route('ajax.product.get_overview_info_product_popup') }}",
                ADD_PRODUCT_TO_WISH_LIST : "{{ route('ajax.product.add_or_remove_product_to_quick_list') }}",
                GET_DETAIL_PRODUCT : "{{ route('ajax.product.get_detail_info_product') }}",
                GET_DETAIL_PRODUCT_BY_ATTRIBUTES : "{{ route('ajax.product.get_detail_info_product_by_attributes') }}",
                DETAIL_PRODUCT_PAGE : "{{ route('public.product.detail', [ 'url' => '' ]) }}",
            };
        </script>

        @section('variable-scripts')
        @show

        <script id="template-mini-cart" type="text/x-handlebars-template">
            @include('handle-bar.mini-cart')
        </script>
        <script id="template-quick-shop-modal" type="text/x-handlebars-template">
            @include('handle-bar.quick-shop-modal')
        </script>
        <script id="template-product-item" type="text/x-handlebars-template">
            @include('handle-bar.product-item')
        </script>
        <script src="{{ asset('frontend/plugins/cart/assets/js/cart-helper.js') }}" type="text/javascript"></script>
        <script src="{{ asset('frontend/plugins/product/assets/js/product.js') }}" type="text/javascript"></script>
        <script src="{{ asset('frontend/plugins/cart/assets/js/cart-coupon.js') }}" type="text/javascript"></script>

        @section('script-media')
            @include('core-media::partials.media')
        @show
        @section('master-footer')
        @show

        <script type="text/javascript">

            let subscribeEmail = function (){
                $.ajax({
                    url : "{{ route('web.newsletter.create') }}",
                    type : "post",
                    data : {
                        _token : _token,
                        email : $("#input-email-subscribe").val()
                    },
                    success : function (data){
                        Lcms.showNotice('success', 'Send email subscribe success', Lcms.languages.notices_msg.success);  
                        $('#input-email-subscribe').val('');
                    },
                    error: function(error) { // if error occured
                        let validations = error.responseJSON.data || {};
                        Object.keys(validations).forEach(function(key) {
                            validations[key].forEach(message =>{
                                Lcms.showNotice('error', message, Lcms.languages.notices_msg.error);  
                            })
                        });
                    }
                });
            }
            $(document).ready(function(){
                $( "#input-email-subscribe" ).keyup(function(e) {
                    if(e.which == 13){
                        subscribeEmail();
                    }
                });
            })
        </script>
    </body>
</html>