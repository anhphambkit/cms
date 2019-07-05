@php
     use Illuminate\Support\Facades\Auth;
@endphp
<header id="header">
    <div class="top-navigation">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 top-navigation-left">{{ theme_option('header') }}</div>
                <div class="col-lg-6 top-navigation-right text-lg-right">
                    <ul class="menu-info-customer">
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
                            <li>
                                <div class="mini-cart-content">
                                    @php
                                        $miniCartInfo = get_info_basic_cart(Auth::guard('customer')->id());
                                    @endphp
                                    <i class="fas fa-shopping-cart">{{ ($miniCartInfo['total_items'] ? "({$miniCartInfo['total_items']})" : '') }}</i>
                                    <div class="mini-cart pb-0" id="mini-cart-header">
                                        <div class="product-list mb-2">
                                           @foreach($miniCartInfo['products'] as $miniCartProduct)
                                                <div class="item">
                                                    <div class="mini-thumbnail-cart">
                                                        <img src="{{ asset($miniCartProduct->image_feature) }}" />
                                                    </div>
                                                    <div class="quantity">x1
                                                        <br />
                                                        @if($miniCartProduct->type_product !== \Plugins\Product\Contracts\ProductReferenceConfig::PRODUCT_TYPE_VARIANT)
                                                            <span class="font-weight-500">${{ ($miniCartProduct->is_has_sale ? number_format($miniCartProduct->sale_price) : number_format($miniCartProduct->price)) }}</span>
                                                        @else
                                                            <div class="font-size-18">${{ number_format($miniCartProduct->min_price) }} - ${{ number_format($miniCartProduct->max_price) }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="name">{{ $miniCartProduct->name }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="cart-order-info font-weight-500 p-0 mb-0">
                                            <div class="list-item">
                                                Subtotal
                                                <span>${{ number_format($miniCartInfo['sub_total']) }}</span>
                                            </div>
                                            <div class="list-item">
                                                Shipping fee
                                                <span>FREE</span>
                                            </div>
                                            <div class="list-item">
                                                Tax
                                                <span>$0</span>
                                            </div>
                                            <hr class="my-1">
                                            <div class="list-item">
                                                Total
                                                <span>${{ number_format($miniCartInfo['total_price']) }}</span>
                                            </div>
                                            <hr>
                                            <div class="font-weight-500 mb-0" style="background: rgba(150,196,189,.2); margin: -15px; padding: 15px;">
                                                <div class="mb-2">Coupon DISCOUNT</div>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control rounded-0" placeholder="Enter your code here" id="mini_coupon_code" name="coupon_code">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary rounded-0 add-coupon-btn" id="add-coupon-btn-mini-cart" type="button">apply</button>
                                                    </div>
                                                </div>
                                                <div class="coupon-in-use">
                                                    @if($miniCartInfo['coupon'])
                                                        <div class="row coupon-{{ $miniCartInfo['coupon']->id }}">
                                                            <div class="text-uppercase mb-2 col-md-8 coupon-code-text">{{ $miniCartInfo['coupon']->code }}</div>
                                                            <div class="text-uppercase mb-2 col-md-4">
                                                                <a class="action-delete-coupon delete-coupon-{{ $miniCartInfo['coupon']->id }}" data-coupon-id="{{ $miniCartInfo['coupon']->id }}">
                                                                    <i class="far fa-trash-alt icon-action-delete-coupon"></i>
                                                                    {{ trans('core-base::forms.delete') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('public.cart') }}">
                                                        <button class="btn btn-outline-custom rounded-0 btn-sm w-50 justify-content-center mr-1">Go to Cart</button>
                                                    </a>
                                                    <a href="{{ route('public.product.checkout') }}">
                                                        <button class="btn btn-outline-custom rounded-0 btn-sm w-50 justify-content-center ml-1">Checkout</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <form action="{{ route('public.product.search') }}" method="get">
                        <div class="input-icon align-right search-input">
                            <button class="btn btn-icon"><i class="fas fa-search"></i></button>
                            <input type="text" class="form-control form-control-lg" placeholder="Search here..." name="search" />
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 text-lg-right action-group">
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
    const imgLoading = "{{ URL::asset('favicon.png') }}";
</script>
    