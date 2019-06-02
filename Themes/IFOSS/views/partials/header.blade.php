@php
     use Illuminate\Support\Facades\Auth;
@endphp
<header id="header">
    <div class="top-navigation">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 top-navigation-left">{{ theme_option('header') }}</div>
                <div class="col-lg-6 top-navigation-right text-lg-right">
                    <ul>
                        <li><a href="javascript:void(0);" class="call">call now {{ theme_option('phone') }}</a></li>
                        @if(Auth::guard('customer')->check())
                            <li class="dropdown dropdown-s1">
                                <a href="javascript:void(0);" role="button" id="account-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> <span>Hello, <strong>{{ $currentAccount->username }}</strong></span>
                                </a>
                                <div class="dropdown-menu text-right text-uppercase" aria-labelledby="account-dropdown">
                                    <a class="dropdown-item" href="{{ route('public.customer.dashboard') }}">My profile</a>
                                    <a class="dropdown-item" href="{{ route('public.customer.my-orders') }}">My orders</a>
                                    <a class="dropdown-item" href="#">Wishlist</a>
                                    <a class="dropdown-item" href="{{ route('public.customer.logout') }}">Logout</a>
                                </div>
                            </li>
                            <li><a href="javascript:void(0);"><i class="fas fa-shopping-cart"></i> (1)</a></li>
                        @else
                            <li><a href="{{ route('public.customer.login') }}"><i class="fas fa-user-circle"></i> <span>Sign In</span></a></li>
                        @endif    
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-white">
        <div class="menu-navigation">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <a href="{{ route('homepage') }}" class="logo">
                        <img src="{{ theme_option('logo') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-3">
                    <form action="">
                        <div class="input-icon align-right search-input">
                            <i class="fas fa-search icon"></i>
                            <input type="text" class="form-control form-control-lg" placeholder="Search here..." />
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 text-lg-right action-group">
                    <button type="button" class="btn btn-outline-danger action-group-item">Sale</button>
                    <button type="button" class="btn btn-outline-custom action-group-item">free design</button>
                    <button type="button" class="btn btn-outline-custom action-group-item">
                        <a class="menu-design-idea menu-link-custom" href="{{ route('public.design-ideal') }}">Design Ideal</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="submenu-navigation bg-white">
        <div class="container">
            <ul class="submenu-navigation-wrapper">
                <?php $menuNavigation = array('furniture','outdoor','lighting','decor','rugs','bed & bath');
                foreach ($menuNavigation as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                <?php } ?>

                <li class="has-megamenu">
                    <a href="#">type business</a>
                    <ul class="mega-menu">
                        <?php for ($j=0; $j < 2; $j++) { ?>
                        <li class="col-md-3">
                            <span class="mega-menu-title">Business Categories</span>
                            <ul class="sub-menu">
                                <?php for ($i=0; $i < 4; $i++) { ?>
                                <li>
                                    <a href="#">Caterory <?php echo $i+1; ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
    