<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-11
 * Time: 17:07
 */
?>
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
