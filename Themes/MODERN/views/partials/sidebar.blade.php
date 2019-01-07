<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            {!! apply_filters(DASHBOARD_FILTER_MENU_NAME, \Request::route()->getName()) !!}
            @foreach ($menus = dashboard_menu()->getAll() as $menu)
                <li class="@if ($menu->active) active @else nav-item @endif" id="{{ $menu->id }}">
                    <a href="{{ $menu->url }}">
                        <i class="{{ $menu->icon }}"></i>
                        <span class="menu-title">{{ $menu->name }}</span>
                        @if (isset($menu->children) && $menu->children->count()) 
                            <span class="arrow @if ($menu->active) open @endif"></span> 
                        @endif
                    </a>
                    @if (isset($menu->children) && $menu->children->count())
                        <ul class="menu-content">
                            @foreach ($menu->children as $item)
                                <li class="@if ($item->active) active @else nav-item @endif" id="{{ $item->id }}">
                                    <a href="{{ $item->url }}">
                                        <i class="{{ $item->icon }}"></i>
                                        {{ $item->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
