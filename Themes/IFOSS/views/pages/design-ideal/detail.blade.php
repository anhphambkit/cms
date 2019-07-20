@extends("layouts.master")
@section('content')
    <section class="product-detail design-ideas-row">
        @component("components.look-book-detail")
            @slot('urlImage', $lookBook->image)
            @slot('nameLookBook', $lookBook->name)
            @slot('currentBusinessName', (!empty($currentBusinessName) ? $currentBusinessName : get_attribute_from_random_array($lookBook->lookBookBusiness->toArray(), 'text')))
            @slot('currentBusinessSlug', (!empty($currentBusinessSlug) ? $currentBusinessSlug : get_attribute_from_random_array($lookBook->lookBookBusiness->toArray(), 'slug')))
            @slot('spaces', $lookBook->lookBookSpacesBelong)
            @slot('tags', $lookBook->lookBookTags)
            @slot('urlLookBook', $lookBook->slug_link)
            @slot('idLookBook', $lookBook->id)
            @slot('wasAddedWishList', $lookBook->was_added_wish_list)
            @slot('tagProducts', $lookBook->look_book_all_products)
        @endcomponent
    </section>
    <section class="product-wrapper">
        <div class="container">
            <div class="h6 text-uppercase text-center mb-3">Items in This Room</div>
            <div class="product-slider-wrapper">
                @foreach($lookBook->lookBookProducts as $lookBookProduct)
                    <div class="px-3 product-item-wrapper">
                        @component("components.product-item")
                            @slot("productItem", $lookBookProduct)
                        @endcomponent
                    </div>
                @endforeach
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

@section('variable-scripts')

@stop