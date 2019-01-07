<li class="{{ $active ? 'active' : ''}}">
	<a href="{{ URL::route($route) }}">
		<i class="la la-home"></i>
		<span class="menu-title" data-i18n="">{{ $title }}</span>
	</a>
</li>