<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-11
 * Time: 17:07
 */
$currentBusinessSlug = !empty($currentBusinessSlug) ? $currentBusinessSlug : '';
$currentBusinessName = !empty($currentBusinessName) ? $currentBusinessName : '';
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
                        @component("components.look-book-item")
                            @slot('typeLookBook', 'main')
                            @slot('urlImage', $list[$i]['image'])
                            @slot('nameLookBook', $list[$i]['name'])
                            @slot('currentBusinessName', (!empty($currentBusinessName) ? $currentBusinessName : get_attribute_from_random_array($list[$i]['look_book_business'], 'text')))
                            @slot('currentBusinessSlug', (!empty($currentBusinessSlug) ? $currentBusinessSlug : get_attribute_from_random_array($list[$i]['look_book_business'], 'slug')))
                            @slot('spaces', $list[$i]['look_book_spaces_belong'])
                            @slot('tags', $list[$i]['look_book_tags'])
                        @endcomponent
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
                                            @component("components.look-book-item")
                                                @slot('typeLookBook', 'normal')
                                                @slot('urlImage', $normalLayoutChunk[$j]['image'])
                                                @slot('nameLookBook', $normalLayoutChunk[$j]['name'])
                                                @slot('currentBusinessName', (!empty($currentBusinessName) ? $currentBusinessName : get_attribute_from_random_array($normalLayoutChunk[$j]['look_book_business'], 'text')))
                                                @slot('currentBusinessSlug', (!empty($currentBusinessSlug) ? $currentBusinessSlug : get_attribute_from_random_array($normalLayoutChunk[$j]['look_book_business'], 'slug')))
                                                @slot('spaces', $normalLayoutChunk[$j]['look_book_spaces_belong'])
                                                @slot('tags', $normalLayoutChunk[$j]['look_book_tags'])
                                            @endcomponent
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
                    @component("components.look-book-item")
                        @slot('typeLookBook', 'vertical')
                        @slot('urlImage', $list[$i]['image'])
                        @slot('nameLookBook', $list[$i]['name'])
                        @slot('currentBusinessName', (!empty($currentBusinessName) ? $currentBusinessName : get_attribute_from_random_array($list[$i]['look_book_business'], 'text')))
                        @slot('currentBusinessSlug', (!empty($currentBusinessSlug) ? $currentBusinessSlug : get_attribute_from_random_array($list[$i]['look_book_business'], 'slug')))
                        @slot('spaces', $list[$i]['look_book_spaces_belong'])
                        @slot('tags', $list[$i]['look_book_tags'])
                    @endcomponent
                </div>
                @php
                    $i++;
                @endphp
            @endif
        @endwhile
    @endforeach
</div>
