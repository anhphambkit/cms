<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
  <div class="navbar-wrapper">
    <div class="navbar-header">
      <ul class="nav navbar-nav flex-row position-relative">
        <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
        <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('/') }}"><img class="brand-logo" alt="modern admin logo" src="{{ theme_option('logo') }}">
            <h3 class="brand-text">{{ theme_option('name') }}</h3></a></li>
        <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
      </ul>
    </div>
    <div class="navbar-container content">
      <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">         
          @include('navbars.nav-left')
        </ul>
        <ul class="nav navbar-nav float-right">
          @include('navbars.nav-right')
        </ul>
      </div>
    </div>
  </div>
</nav>
<script type="text/javascript">
    const _token = "{{ csrf_token() }}";
</script>
    