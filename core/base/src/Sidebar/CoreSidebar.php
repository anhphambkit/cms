<?php
declare(strict_types=1);
namespace Core\Base\Sidebar;

class CoreSidebar
{
	/**
	 * Get list menu
	 * @author TrinhLe
	 * @return array
	 */
	protected static function getMenus():array{
		return [];
	}

	/**
	 * Register dashboar menu session
	 * @author TrinhLe
	 */
	public static function register()
	{
		$menus = static::getMenus();

		foreach ($menus as $key => $menu) {
			dashboard_menu()->registerItem($menu);
		}
	}
}