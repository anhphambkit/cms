<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-06-29
 * Time: 08:02
 */
$arraySorts = [
    'name_asc' => [
        'route' => "{$currentRoute}?orderBy=name&sortOrder=asc",
        'title' => trans('plugins-product::front-end.sort_title.alphabet_asc')
    ],
    'name_desc' => [
        'route' => "{$currentRoute}?orderBy=name&sortOrder=desc",
        'title' => trans('plugins-product::front-end.sort_title.alphabet_desc')
    ],
    'price_asc' => [
        'route' => "{$currentRoute}?orderBy=price&sortOrder=asc",
        'title' => trans('plugins-product::front-end.sort_title.price_asc')
    ],
    'price_desc' => [
        'route' => "{$currentRoute}?orderBy=price&sortOrder=desc",
        'title' => trans('plugins-product::front-end.sort_title.price_desc')
    ]
];
$currentSortName = 'name_asc';
if (!empty(request()->orderBy) && !empty(request()->sortOrder)) {
    $currentSortName = request()->orderBy . "_" . request()->sortOrder;
}
$currentSort = $arraySorts[$currentSortName];
unset($arraySorts[$currentSortName]);
?>
<div class="dropdown dropdown-s1">
    <button class="btn btn-outline-custom dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $currentSort['title'] }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @foreach($arraySorts as $arraySort)
            <a class="dropdown-item" href="{{ $arraySort['route'] }}">{{ $arraySort['title'] }}</a>
        @endforeach
    </div>
</div>
