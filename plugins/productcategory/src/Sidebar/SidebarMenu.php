<?php
namespace Plugins\Productcategory\Sidebar;
use Core\Base\Sidebar\CoreSidebar;

class SidebarMenu extends CoreSidebar
{
    /**
     * Defined menu plugin
     * @author TrinhLe
     * @return array
     */
    protected static function getMenus():array{
        return [
        	[
				'id'          => 'plugin-products',
				'priority'    => 2,
				'parent_id'   => null,
				'name'        => __('Manage Products'),
				'icon'        => 'fab fa-product-hunt',
				'url'         => null,
				'permissions' => ['productcategory.list']
            ],
            [
				'id'          => 'plugin-product-category',
				'priority'    => 1,
				'parent_id'   => 'plugin-products',
				'name'        => __('Categories'),
				'icon'        => 'fas fa-align-left',
				'url'         => route('productcategory.list'),
				'permissions' => ['productcategory.list']
            ],
            [
				'id'          => 'plugin-product-product',
				'priority'    => 2,
				'parent_id'   => 'plugin-products',
				'name'        => __('Products'),
				'icon'        => 'fab fa-product-hunt',
				'url'         => route('productcategory.list'),
				'permissions' => ['productcategory.list']
            ]
        ];
    }
}