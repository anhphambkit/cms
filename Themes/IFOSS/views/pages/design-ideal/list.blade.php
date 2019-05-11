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
                                <div class="row design-ideas-row">
                                    @foreach($listRender as $list)
                                        @php
                                            $i = 0;
                                        @endphp
                                        @while($i < sizeof($list))
                                            @if($list[$i]['type_layout'] === 'Normal')
                                                    @if($list[$i]['is_main'])
                                                        <div class="col-md-8">
                                                            <div class="item main-look-book item-look-book">
                                                                <img src="{{ URL::asset($list[$i]['image']) }}"/>
                                                                <div class="design-ideas-overlay-content">
                                                                    <div class="title">{{ $list[$i]['name'] }}</div>
                                                                    <ul class="tag">
                                                                        <li>Business <a href="#">Nail Salon</a></li>
                                                                        <li>Space <a href="#">Lounge</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $normalLayoutTmp = array();
                                                        @endphp
                                                        @while($i < sizeof($list) && $list[$i]['type_layout'] === 'Normal')
                                                            @php
                                                                array_push($normalLayoutTmp, $list[$i]);
                                                                $i++;
                                                            @endphp
                                                        @endwhile
                                                        @php
                                                            $normalLayoutChunks = array_chunk($normalLayoutTmp, 6);
                                                        @endphp
                                                        @foreach($normalLayoutChunks as $normalLayoutChunk)
                                                            @php
                                                                $colRender = round(sizeof($normalLayoutChunk)/2)*4;
                                                                $j = 0;
                                                            @endphp
                                                            <div class="col-md-{{$colRender}}">
                                                                <div class="item sub-item">
                                                                    <div class="row">
                                                                        @while($j < sizeof($normalLayoutChunk))
                                                                            <div class="col-md-{{ ($colRender == 12) ? 4 : ($colRender == 8) ? 6 : 12 }}">
                                                                                <div class="item normal-look-book item-look-book">
                                                                                    <img src="{{ URL::asset($normalLayoutChunk[$j]['image']) }}"/>
                                                                                    <div class="design-ideas-overlay-content">
                                                                                        <div class="title">{{ $normalLayoutChunk[$j]['name'] }}</div>
                                                                                        <ul class="tag">
                                                                                            <li>Business <a href="#">Nail Salon</a></li>
                                                                                            <li>Space <a href="#">Lounge</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            @php
                                                                                $j++;
                                                                            @endphp
                                                                        @endwhile
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                            @elseif($list[$i]['type_layout'] === 'Vertical')
                                                <div class="col-md-4">
                                                    <div class="item vertical-look-book item-look-book">
                                                        <img src="{{ URL::asset($list[$i]['image']) }}"/>
                                                        <div class="design-ideas-overlay-content">
                                                            <div class="title">{{ $list[$i]['name'] }}</div>
                                                            <ul class="tag">
                                                                <li>Business <a href="#">Nail Salon</a></li>
                                                                <li>Space <a href="#">Lounge</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endif
                                        @endwhile
                                    @endforeach
                                </div>
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