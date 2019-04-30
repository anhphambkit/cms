@extends("layouts.master")

@section('content')

    <section class="banner-slider">
        <?php for ($i=0; $i < 3; $i++) { ?>
            <div class="item">
                <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner1.jpg') }} "/>
                <div class="content">
                    <div class="title">Free Design</div>
                    <div class="descriptions"> for qualifying orders over $3000</div>
                </div>
            </div>
        <?php } ?>
    </section>

    <section class="banner-advertisement">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 item vertical-layout">
                    <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner2.jpg') }} "/>
                    <div class="content">
                        <div class="tag">Decor</div>
                        <div class="title">new arrivals off 20%</div>
                        <a href="#" class="action">Shop now</a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-4 px-0 small-thumbnail">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner3.jpg') }} "/>
                        </div>
                        <div class="col-lg-8 item horizontal-layout">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner4.jpg') }} "/>
                            <div class="content">
                                <div class="tag">furniture</div>
                                <div class="title" style="max-width: 190px;">the living room’s</div>
                                <a href="#" class="action">Shop now</a>
                            </div>
                        </div>

                        <div class="col-lg-8 item horizontal-layout">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner5.jpg') }} "/>
                            <div class="content">
                                <div class="tag">Decor</div>
                                <div class="title">new arrivals off 20%</div>
                                <a href="#" class="action">Shop now</a>
                            </div>
                        </div>
                        <div class="col-lg-4 px-0 small-thumbnail">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/banner/banner6.jpg') }} "/>
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
                    <div class="col-md-4 item">
                        <div class="thumbnail">
                            @php
                                $index = $key + 1;
                                $url = "themes/ifoss/assets/images/banner/banner-vector{$index}.png";
                            @endphp
                            <img src="{{ URL::asset($url) }}" style="max-width: <?php echo $bannerFeatureThumbnailWidth[$key];?>"/>
                        </div>
                        <div class="descriptions"><?php echo $value; ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="product-categories">
        <div class="text-center">
            <div class="section-title">Trending Design</div>
        </div>
        <div class="tabs">
            <ul class="nav nav-outline">
                <?php $productCategoriesTitle = array('Living room ','Dining room','Work room', 'Bedroom');
                foreach ($productCategoriesTitle as $key => $value) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($key==2) echo 'active'; ?>" href="#category-<?php echo $key; ?>" data-toggle="pill" role="tab"><?php echo $value; ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <?php for ($i=0; $i < 4; $i++) { ?>
                    <div class="tab-pane fade <?php if($i==2) echo 'show active'; ?>" id="category-<?php echo $i; ?>" role="tabpanel">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-8 item">
                                    <img src="{{ URL::asset('themes/ifoss/assets/images/categories/category1.jpg') }} ">
                                </div>
                                <div class="col-lg-4 item small-picture bg-white">
                                    <img src="{{ URL::asset('themes/ifoss/assets/images/categories/category2.jpg') }}">
                                    <div class="item-title">Chairs & Armchairs</div>
                                    <div class="item-price">$1200</div>
                                </div>
                            </div>
                            <div class="row">
                                <?php for ($j=4; $j < 9; $j++) { ?>
                                    <div class="item-touch">
                                        @php
                                            $url = "themes/ifoss/assets/images/categories/category{$j}.jpg";
                                        @endphp
                                        <img src="{{ URL::asset($url) }}">
                                        <a href="#" class="item-touch-mask">
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
            <div class="section-title">Best sellers</div>
        </div>
        <div class="container">
            <div class="row product-slider--wrapper">
                <?php for ($i=0; $i < 2; $i++) { ?>
                    <?php for ($j=0; $j < 4; $j++) { ?>
                        <div class="col-md-3">
                            <div class="item">
                                <div class="thumbnail" >
                                    @php
                                        $index = $j + 1;
                                        $url = "themes/ifoss/assets/images/products/product{$index}.jpg";
                                    @endphp
                                    <img src="{{ URL::asset($url) }}">
                                    <div class="mask">
                                        <button class="btn btn-white">quick view</button>
                                        <a href="#" class="favourite"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                                <div class="title">Basics Metal Box Spring</div>
                                <div class="cost">
                                    <div class="discount">$5560</div>
                                    <div class="original-cost">$4560</div>
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
@stop