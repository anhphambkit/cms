<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>IFOSS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('themes/ifoss/assets/images/favicon.png') }} ">
    <!-- App css -->
    <link href="{{ URL::asset('themes/ifoss/assets/css/style.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<style>

</style>

<body style="background-color: #f5f5f5;">
    <header>
    <div class="top-navigation">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 top-navigation--left">free design for qualifying orders over $3000</div>
                <div class="col-lg-6 top-navigation--right text-lg-right">
                    <ul>
                        <li><a href="javascript:void(0);" class="call">call now (714) 556-7895</a></li>
                        <li><a href="javascript:void(0);"><i class="fas fa-user-circle"></i> <span>My Account</span></a></li>
                        <li><a href="javascript:void(0);"><i class="fas fa-shopping-cart"></i> (1)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-white">
        <div class="menu-navigation">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="logo">
                        <img src="{{ URL::asset('themes/ifoss/assets/images/logo.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-3">
                    <form action="">
                        <div class="input-icon align-right search-input">
                            <i class="fas fa-search icon"></i>
                            <input type="text" class="form-control" placeholder="Search here..." />
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 text-lg-right action-group">
                    <button type="button" class="btn btn-outline-danger action-group--item">Sale</button>
                    <button type="button" class="btn btn-outline-custom action-group--item">free design</button>
                    <div class="dropdown d-inline-block action-group--item">
                        <a class="btn btn-outline-custom dropdown-toggle" href="#" role="button" id="dropdownDesignIdeas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">design ideas</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownDesignIdeas">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="submenu-navigation bg-white">
        <div class="container">
            <ul>
                <?php $menuNavigation = array('furniture','outdoor','lighting','decor','rugs','bed & bath','type business');
                foreach ($menuNavigation as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</header>
    <section class="banner-slider">
        <?php for ($i=0; $i < 3; $i++) { ?>
            <div class="banner-slider--item">
                <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner1.jpg') }} "/>
                <div class="banner-slider--item--content">
                    <div class="banner-slider--item--content--title">Free Design</div>
                    <div class="banner-slider--item--content--descriptions"> for qualifying orders over $3000</div>
                </div>
            </div>
        <?php } ?>
    </section>

    <section class="banner-advertisement">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 banner-advertisement--item vertical-layout">
                    <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner2.jpg') }} "/>
                    <div class="banner-advertisement--item--content">
                        <div class="banner-advertisement--item--tag">Decor</div>
                        <div class="banner-advertisement--item--title">new arrivals off 20%</div>
                        <a href="#" class="banner-advertisement--item--action">Shop now</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 px-0 small-thumbnail">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner3.jpg') }}"/>
                        </div>
                        <div class="col-lg-8 banner-advertisement--item horizontal-layout">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner4.jpg') }}"/>
                            <div class="banner-advertisement--item--content">
                                <div class="banner-advertisement--item--tag">furniture</div>
                                <div class="banner-advertisement--item--title" style="max-width: 190px;">the living room’s</div>
                                <a href="#" class="banner-advertisement--item--action">Shop now</a>
                            </div>
                        </div>

                        <div class="col-lg-8 banner-advertisement--item horizontal-layout">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner5.jpg') }}"/>
                            <div class="banner-advertisement--item--content">
                                <div class="banner-advertisement--item--tag">Decor</div>
                                <div class="banner-advertisement--item--title">new arrivals off 20%</div>
                                <a href="#" class="banner-advertisement--item--action">Shop now</a>
                            </div>
                        </div>
                        <div class="col-lg-4 px-0 small-thumbnail">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner6.jpg') }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="banner-feature">
        <div class="container">
            <div class="row">
                <?php $bannerFeatureDescriptions = array('Free design for qualifying orders','Free & fast shipping on all orders','Top-rated, high-quality products for Commercial ');
                $bannerFeatureThumbnailWidth= array('169px','144px','102px');
                foreach ($bannerFeatureDescriptions as $key => $value) {
                    ?>
                    <div class="col-md-4 banner-feature--item">
                        <div class="banner-feature--item--thumbnail">
                            @php
                                $index = $key + 1;
                                $url = "themes/ifoss/assets/images/banner/banner-vector{$index}.png";
                            @endphp
                            <img src="{{ URL::asset($url) }}" style="max-width: <?php echo $bannerFeatureThumbnailWidth[$key];?>"/>
                        </div>
                        <div class="banner-feature--item--descriptions"><?php echo $value; ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="product-categories">
        <div class="text-center">
            <div class="section--title">Trending Design</div>
        </div>
        <div class="product-categories--tabs">
            <ul class="nav nav-outline">
                <?php $productCategoriesTitle = array('Living room ','Dining room','Work room', 'Bedroom');
                foreach ($productCategoriesTitle as $key => $value) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($key==2) echo 'active'; ?>" href="#category-<?php echo $key; ?>" data-toggle="pill" role="tab"><?php echo $value; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content product-categories--tab-content">
                <?php for ($i=0; $i < 4; $i++) { ?>
                    <div class="tab-pane fade <?php if($i==2) echo 'show active'; ?>" id="category-<?php echo $i; ?>" role="tabpanel">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-8 product-categories--tab-content--item">
                                    <img src="{{ URL::asset('themes/ifoss/assets/images/categories/category1.jpg') }} ">
                                </div>
                                <div class="col-lg-4 product-categories--tab-content--item small-picture bg-white">
                                    <img src="{{ URL::asset('themes/ifoss/assets/images/categories/category2.jpg') }}">
                                    <div class="product-categories--tab-content--item--title">Chairs & Armchairs</div>
                                    <div class="product-categories--tab-content--item--price">$1200</div>
                                </div>
                            </div>
                            <div class="row">
                                <?php for ($j=4; $j < 9; $j++) { ?>
                                    <div class="product-categories--tab-content--item-touch">

                                        @php
                                            $index = $key + 1;
                                            $url = "themes/ifoss/assets/images/categories/category{$j}.jpg";
                                        @endphp
                                        <img src="{{ URL::asset($url) }}">
                                        <a href="#" class="product-categories--tab-content--item-touch--mask">
                                            <img src="{{ URL::asset('themes/ifoss/assets/images/icons/hand-click.png') }}">
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="text-center">
                                <a href="#" class="btn-with-hr">View all</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="product-slider">
        <div class="text-center">
            <div class="section--title">Best sellers</div>
        </div>
        <div class="container">
            <div class="row product-slider--wrapper">
                <?php for ($i=0; $i < 2; $i++) { ?>
                    <?php for ($j=0; $j < 4; $j++) { ?>
                        <div class="col-md-3">
                            <div class="product-slider--wrapper--item">
                                <div class="product-slider--wrapper--item--thumbnail" >
                                    @php
                                        $index = $j + 1;
                                        $url = "themes/ifoss/assets/images/products/product{$index}.jpg";
                                    @endphp
                                    <img src="{{ URL::asset($url) }}">
                                    <div class="product-slider--wrapper--item--mask">
                                        <button class="btn btn-white">quick view</button>
                                        <a href="#" class="product-slider--wrapper--item--favourite"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="product-slider--wrapper--item--title">Basics Metal Box Spring</div>
                                <div class="product-slider--wrapper--item--cost">
                                    <div class="product-slider--wrapper--item--cost--discount">$5560</div>
                                    <div class="product-slider--wrapper--item--cost--original-cost">$4560</div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="text-center">
                <a href="#" class="btn-with-hr">Show all</a>
            </div>
        </div>
    </section>

    <section class="news-letter">
        <div class="container">
            <div class="news-letter--wrapper row">
                <div class="col-md-6">
                    <div class="news-letter--wrapper--title">Be the first to know about our daily sales!</div>
                </div>
                <div class="col-md-6">
                    <form>
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Email address" />
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-custom">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-wrapper">
    <div class="container">
        <div class="row footer-wrapper--top">
            <div class="col-md-3 col-sm-6">
                <div class="footer-wrapper--title">About Us</div>
                <ul class="footer-wrapper--link">
                    <?php $footerLink = array('About iFoss','Careers','Investor Relations','Locations');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-wrapper--title">Customer Service</div>
                <ul class="footer-wrapper--link">
                    <?php $footerLink = array('My Orders','Return Policy','Help Center');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="footer-wrapper--title">Contact Us</div>
                <ul class="footer-wrapper--link">
                    <li>
                        <button class="btn btn-outline-custom"><i class="fas fa-phone-volume text-danger"></i> Call us</button>
                    </li>
                    <li>
                        <button class="btn btn-custom"><i class="fas fa-clock"></i> Quick Service </button>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-6">
                <ul class="footer-wrapper--link work-time" style="margin-top: 55px;">
                    <li> Mon - Fri: 8AM - midnight</li>
                    <li>Sat: 8AM - 8PM      I      Sun: 9AM - 6PM</li>
                    <li>All times Eastern</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="row footer-wrapper--bottom">
            <div class="col-md-6">
                <ul class="footer-wrapper--link--inline">
                    <?php $footerLink = array('Privacy Policy','Terms of Use','Interest-Based Ads');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#"><?php echo $value; ?></a></li>
                    <?php } ?>
                </ul>
                <div class="footer-wrapper--bottom--copyright">© Copyright 2019 iFoss inc | Design by Tinyprovider.com</div>
            </div>
            <div class="col-md-6">
                <ul class="footer-wrapper--link--social justify-content-md-end">
                    <?php $footerLink = array('fab fa-facebook-f','fab fa-instagram','fab fa-youtube', 'fab fa-twitter', 'fab fa-google-plus-g');
                    foreach ($footerLink as $key => $value) {
                    ?>
                    <li><a href="#" class="<?php echo $value; ?>"></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="{{ URL::asset('themes/ifoss/assets/js/style.min.js') }} "></script>
</html>