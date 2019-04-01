<?php

namespace Plugins\Product;

use Artisan;
use Core\Master\Supports\PermissionCommand;
use Schema;
class Plugin
{

    /**
     * @return array
     * @author TrinhLe
     */
    public static function permissions()
    {
        return [
            [
                'name' => 'Product',
                'flag' => 'product.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Create',
                'flag' => 'product.create',
                'parent_flag' => 'product.list',
            ],
            [
                'name' => 'Edit',
                'flag' => 'product.edit',
                'parent_flag' => 'product.list',
            ],
            [
                'name' => 'Delete',
                'flag' => 'product.delete',
                'parent_flag' => 'product.list',
            ]
        ];
    }

    /**
     * @author Sang Nguyen
     */
    public static function activate()
    {
        PermissionCommand::registerPermission(self::permissions());
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
        ]);
    }

    /**
     * @author Sang Nguyen
     */
    public static function deactivate()
    {

    }

    /**
     * @author Sang Nguyen
     */
    public static function remove()
    {
        PermissionCommand::removePermission(self::permissions());
        Schema::dropIfExists('product');
    }
}