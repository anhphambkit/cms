<?php

namespace Plugins\Productcategory;

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
                'name' => 'Productcategory',
                'flag' => 'productcategory.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Create',
                'flag' => 'productcategory.create',
                'parent_flag' => 'productcategory.list',
            ],
            [
                'name' => 'Edit',
                'flag' => 'productcategory.edit',
                'parent_flag' => 'productcategory.list',
            ],
            [
                'name' => 'Delete',
                'flag' => 'productcategory.delete',
                'parent_flag' => 'productcategory.list',
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
            '--path' => 'plugins/productcategory/database/migrations',
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
        Schema::dropIfExists('productcategory');
    }
}