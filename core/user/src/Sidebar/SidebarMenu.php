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
				'id'          => 'cms-core-administrator',
				'priority'    => 1,
				'parent_id'   => null,
				'name'        => __('Administrators'),
				'icon'        => 'fas fa-users-cog',
				'url'         => null,
				'permissions' => ['user.index']
            ],
            [
				'id'          => 'cms-core-user',
				'priority'    => 1,
				'parent_id'   => 'cms-core-administrator',
				'name'        => __('Manage Users'),
				'icon'        => 'fas fa-users',
				'url'         => route('admin.user.index'),
				'permissions' => ['user.index']
            ],
            [
				'id'          => 'cms-core-role',
				'priority'    => 2,
				'parent_id'   => 'cms-core-administrator',
				'name'        => __('Manage Roles'),
				'icon'        => 'fas fa-cogs',
				'url'         => route('admin.role.index'),
				'permissions' => ['role.index']
            ]
		];
	}
}