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
                                    <a class="dropdown-item" href="{{ route('public.product.wish_list') }}">Wishlist</a>
                                    <a class="dropdown-item" href="{{ route('public.customer.logout') }}">Logout</a>
                                </div>
                            </li>
                            <li><a href="{{ route('public.cart') }}" class="shopping-cart-quantity">
                                    @php
                                        $totalItemsInCart = get_total_items_in_cart();
                                    @endphp
                                    <i class="fas fa-shopping-cart">{{ ($totalItemsInCart ? "({$totalItemsInCart})" : '') }}</i>
                                </a>
                            </li>
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
                @php
                    $menu_categories = get_menu_product_categories();
                @endphp
                @foreach ($menu_categories as $key => $menu_category)
                    <li class="has-megamenu no-caret">
                        <a href="{{ route('public.category.detail', [ 'url' => $menu_category->url_product_category ]) }}">{{ $menu_category->name }}</a>
                        <ul class="mega-menu tab-menu">
                            @foreach ($menu_category->childCategories as $child_menu_category)
                            <li class="col-md-2">
                                <a href="{{ route('public.category.sub_category', [ 'url' => $menu_category->url_product_category, 'subCategory' => $child_menu_category->url_product_category ]) }}" class="item">
                                    <img src="{{ get_object_image($child_menu_category->image_feature, 'mediumThumb') }}" class="w-100">
                                    <div class="title">{{ $child_menu_category->name }}</div>
                                </a>
                            </li>
                            @endforeach
                            <li class="col-md-2">
                                <a href="{{ route('public.category.sale.page', [ 'url' => $menu_category->url_product_category ]) }}" class="item">
                                    <img src="{{ asset('themes/ifoss/assets/images/products/product-chair-tabmenu-7.png') }}" class="w-100">
                                    <div class="title text-danger">Sale</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</header>
<script type="text/javascript">
    const _token = "{{ csrf_token() }}";
</script>
    