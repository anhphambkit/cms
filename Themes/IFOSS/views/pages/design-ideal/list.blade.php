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
                <div class="tab-pane fade show active" id="category-2" role="tabpanel">
                        <div class="design-ideas">
                            <div class="container-fluid">
                                @include("pages.partials.list-look-book")
                                <div class="text-center py-4">
                                    <a href="javascript:void(0);" class="btn-view-icon"><i class="fas fa-plus"></i> <span>Load more</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
@stop