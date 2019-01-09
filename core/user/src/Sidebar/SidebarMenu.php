<?php
namespace Core\User\Sidebar;
use Core\Base\Sidebar\CoreSidebar;

class SidebarMenu extends CoreSidebar
{
	/**
	 * Get list menu
	 * @author TrinhLe
	 * @return array
	 */
	protected static function getMenus():array{
		return [
			[
				'id'          => 'cms-core-user',
				'priority'    => 1,
				'parent_id'   => null,
				'name'        => __('Manage Users'),
				'icon'        => 'la la-unlock',
				'url'         => route('admin.user.index'),
				'permissions' => ['user.index']
            ],
            [
				'id'          => 'cms-core-role',
				'priority'    => 2,
				'parent_id'   => null,
				'name'        => __('Manage Roles'),
				'icon'        => 'la la-unlock',
				'url'         => route('admin.role.index'),
				'permissions' => ['role.index']
            ]
		];
	}
}