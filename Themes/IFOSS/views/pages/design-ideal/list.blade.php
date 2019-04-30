@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php $breadcrumbItem = array('Design ideas', 'Beauty', 'Nail salon'); 
                foreach ($breadcrumbItem as $key => $value) { ?>
                <li class="breadcrumb-item"><a href="#"><?php echo $value; ?></a></li>
                <?php } ?>
                <li class="breadcrumb-item active" aria-current="page">All room</li>
            </ol>
        </nav>
    </div>
    <section class="product-categories">
        <div class="product-categories--tabs">
            <div class="container">
                <ul class="nav nav-outline mb-4">
                    <?php $productCategoriesTitle = array('all room','reception room','dining rooms','foyers','toilet','living rooms','office');
                    foreach ($productCategoriesTitle as $key => $value) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($key==0) echo 'active'; ?>" href="#category-<?php echo $key; ?>" data-toggle="pill" role="tab"><?php echo $value; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tab-content product-categories--tab-content">
                <?php for ($i=0; $i < 4; $i++) { ?>
                    <div class="tab-pane fade <?php if($i==2) echo 'show active'; ?>" id="category-<?php echo $i; ?>" role="tabpanel">
                        <div class="design-ideas">
                            <div class="container-fluid">
                                <div class="row design-ideas-row">
                                    <div class="col-md-8">
                                        <div class="item">
                                            <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-5.jpg') }}"/>
                                            <div class="design-ideas-overlay-content">
                                                <div class="title">Modern & Contemporary Foyer Design</div>
                                                <ul class="tag">
                                                    <li>Business <a href="#">Nail Salon</a></li>
                                                    <li>Space <a href="#">Lounge</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="item sub-item">
                                            <div class="item">
                                                <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-6.jpg') }}"/>
                                                <div class="design-ideas-overlay-content">
                                                    <div class="title">Modern & Contemporary Foyer Design</div>
                                                    <ul class="tag">
                                                        <li>Business <a href="#">Nail Salon</a></li>
                                                        <li>Space <a href="#">Lounge</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-7.jpg') }}"/>
                                                <div class="design-ideas-overlay-content">
                                                    <div class="title">Modern & Contemporary Foyer Design</div>
                                                    <ul class="tag">
                                                        <li>Business <a href="#">Nail Salon</a></li>
                                                        <li>Space <a href="#">Lounge</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="item sub-item">
                                            <div class="row">
                                                <?php for ($j=6; $j < 10; $j++) { ?>
                                                    @php
                                                        $url = "themes/ifoss/assets/images/ideas/design-ideas-{$j}.jpg";
                                                    @endphp
                                                <div class="col-md-6">
                                                    <div class="item">
                                                        <img src="{{ URL::asset($url) }}"/>
                                                        <div class="design-ideas-overlay-content">
                                                            <div class="title">Modern & Contemporary Foyer Design</div>
                                                            <ul class="tag">
                                                                <li>Business <a href="#">Nail Salon</a></li>
                                                                <li>Space <a href="#">Lounge</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="item">
                                            <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-10.jpg') }}"/>
                                            <div class="design-ideas-overlay-content">
                                                <div class="title">Modern & Contemporary Foyer Design</div>
                                                <ul class="tag">
                                                    <li>Business <a href="#">Nail Salon</a></li>
                                                    <li>Space <a href="#">Lounge</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="item">
                                            <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-10.jpg') }}"/>
                                            <div class="design-ideas-overlay-content">
                                                <div class="title">Modern & Contemporary Foyer Design</div>
                                                <ul class="tag">
                                                    <li>Business <a href="#">Nail Salon</a></li>
                                                    <li>Space <a href="#">Lounge</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="item sub-item">
                                            <div class="row">
                                                <?php for ($j=6; $j < 10; $j++) { ?>
                                                    @php
                                                        $url = "themes/ifoss/assets/images/ideas/design-ideas-{$j}.jpg";
                                                    @endphp
                                                <div class="col-md-6">
                                                    <div class="item">
                                                        <img src="{{ URL::asset($url) }}"/>
                                                        <div class="design-ideas-overlay-content">
                                                            <div class="title">Modern & Contemporary Foyer Design</div>
                                                            <ul class="tag">
                                                                <li>Business <a href="#">Nail Salon</a></li>
                                                                <li>Space <a href="#">Lounge</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a href="javascript:void(0);" class="btn-view-icon"><i class="fas fa-plus"></i> <span>Load more</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
@stop