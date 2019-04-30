@extends("layouts.master")
@section('content')
    <section class="product-detail">
        <img src="{{ URL::asset('themes/ifoss/assets/images/ideas/design-ideas-detail.jpg') }}" class="w-100">
        <div class="design-ideas-overlay-content is-static">
            <div class="container">
                <div class="row mx-0 justify-content-between align-items-center">
                    <div>
                        <div class="title">Modern & Contemporary Foyer Design</div>
                        <ul class="tag">
                            <li>Business <a href="#">Nail Salon</a></li>
                            <li>Space <a href="#">Lounge</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-custom"><i class="fas fa-heart text-save mr-1"></i> Save</button>
                </div>
            </div>
        </div>
    </section>
    <section class="product-wrapper">
        <div class="container">
            <div class="h6 text-uppercase text-center mb-3">Items in This Room</div>
            <div class="row">
                <?php for ($i=0; $i < 2; $i++) { ?>
                    <?php for ($j=0; $j < 4; $j++) { ?>
                        <div class="col-md-3">
                            <div class="item">
                                <div class="thumbnail" >
                                    @php
                                        $url = "themes/ifoss/assets/images/products/product{$j+1}.jpg";
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
            <hr class="bg-custom mb-4">
            <div class="h6 text-uppercase text-center mb-3">Try something similar</div>
            <div class="row">
                <?php for ($j=0; $j < 4; $j++) { ?>
                    <div class="col-md-3">
                        <div class="item">
                            <div class="thumbnail" >
                                @php
                                    $url = "themes/ifoss/assets/images/products/product{$j+1}.jpg";
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
            </div>
            <hr class="bg-custom mb-4">
            <div class="h6 text-uppercase text-center mb-3">Try something similar</div>
            <div class="product-slider">
                <div class="row product-slider--wrapper">
                    <?php for ($i=0; $i < 2; $i++) { ?>
                        <?php for ($j=0; $j < 4; $j++) { ?>
                            <div class="col-md-3">
                                <div class="item">
                                    <div class="thumbnail mb-0">
                                        @php
                                            $url = "themes/ifoss/assets/images/products/product{$j+1}.jpg";
                                        @endphp
                                        <img src="{{ URL::asset('$url') }}">
                                        <div class="mask">
                                            <button class="btn btn-white">quick view</button>
                                            <a href="#" class="favourite"><i class="far fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <section class="design-ideas">
        <div class="container-fluid">
            <div class="text-center">
                <div class="section-title-s2">Discover more Lounge spaces</div>
            </div>
            <div class="row design-ideas-row">
                <?php for ($j=6; $j < 9; $j++) { ?>
                <div class="col-md-4">
                    <div class="item">
                        @php
                            $url = "themes/ifoss/assets/images/ideas/design-ideas-{$j}.jpg";
                        @endphp
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
    </section>
@stop