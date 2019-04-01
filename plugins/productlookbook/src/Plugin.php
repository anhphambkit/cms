<?php

namespace Plugins\Productlookbook;

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
                'name' => 'Productlookbook',
                'flag' => 'productlookbook.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Create',
                'flag' => 'productlookbook.create',
                'parent_flag' => 'productlookbook.list',
            ],
            [
                'name' => 'Edit',
                'flag' => 'productlookbook.edit',
                'parent_flag' => 'productlookbook.list',
            ],
            [
                'name' => 'Delete',
                'flag' => 'productlookbook.delete',
                'parent_flag' => 'productlookbook.list',
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
            '--path' => 'plugins/productlookbook/database/migrations',
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
        Schema::dropIfExists('productlookbook');
    }
}