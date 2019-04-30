@extends("layouts.master")
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>
        <div class="filter-categories">
            <div class="filter-categories-title">Select your business type</div>
            <div class="content">
                <div class="row">
                    <?php 
                    $filterCategoriesTitle = array('Beauty', 'FOOD & BEVERAGE', 'RETAIL TRADE', 'PROFESSIONAL TRADE');
                    $filterCategoriesItem = array(
                        0 => array('Nail Salon','Hair Salon','Spas','Eyebrow / eyelash studio','Cosmetic surgery office'),
                        1 => array('Restaurant','Coffee & Tea','Hotels','Motels'),
                        2 => array('Cosmetic, beauty supply, perfume store', 'Clothing boutiques'),
                        3 => array('Dental Office','Doctor Office','Real estate / Finance office','Law Office')
                    );
                    foreach ($filterCategoriesTitle as $key => $value) {
                    ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="content-title"><?php echo $value; ?></div>
                        <ul class="content-item">
                            <?php foreach ($filterCategoriesItem[$key] as $key => $value) { ?>
                            <li><a href="#"><?php echo $value; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <section class="design-ideas">
        <div class="container-fluid">
            <div class="text-center">
                <div class="section-title-s2">New design ideas</div>
            </div>
            <div class="row design-ideas-row">
                <div class="col-md-4">
                    <div class="item">
                        <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-1.jpg') }}"/>
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
                            <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-2.jpg') }}"/>
                            <div class="design-ideas-overlay-content">
                                <div class="title">Modern & Contemporary Foyer Design</div>
                                <ul class="tag">
                                    <li>Business <a href="#">Nail Salon</a></li>
                                    <li>Space <a href="#">Lounge</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-3.jpg') }}"/>
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
                <div class="col-md-4">
                    <div class="item">
                        <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-4.jpg') }}"/>
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
            <div class="text-center py-4">
                <a href="javascript:void(0);" class="btn-view-icon"><i class="fas fa-plus"></i> <span>Load more</span></a>
            </div>
        </div>
    </section>
@stop