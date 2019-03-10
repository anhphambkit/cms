<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>lcms laravel</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

    @foreach($cssFiles as $css)
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset($css) }}">
    @endforeach

    @section('styles')
    @show

    @section('master-head')
    @show
  </head>
  <body class="@yield('body-class') vertical-layout vertical-menu-modern 2-columns  menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" id="@yield('body-id', 'module')">
    @include('partials.header')
    @include('partials.sidebar')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                </div>
            </div>
            <div class="content-body">
                @section('content')
                @show
            </div>                
        </div>
    </div>

    @foreach($jsFiles as $js)
        <script src="{{ URL::asset($js) }}" type="text/javascript"></script>
    @endforeach
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('core/base/assets/js/datatables.js') }}"></script>
    <script src="{{ URL::asset('core/base/assets/js/script.js') }}"></script>
    
    @section('scripts')
    @show
    @stack('js-stack')

    @section('script-table')
    @show

    @include('core-base::elements.common')

    @section('script-media')
        @include('core-media::partials.media')
    @show
  </body>
</html>