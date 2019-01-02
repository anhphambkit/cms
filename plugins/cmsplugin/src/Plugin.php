<?php

namespace Plugins\Cmsplugin;

use Artisan;
use Core\Base\Supports\Commands\Permission;
use Schema;
use Core\Base\Interfaces\PluginInterface;

class Plugin implements PluginInterface
{

    /**
     * @return array
     * @author Sang Nguyen
     */
    public static function permissions()
    {
        return [
            [
                'name' => 'Cmsplugin',
                'flag' => 'cmsplugin.list',
                'is_feature' => true,
            ],
            [
                'name' => 'Create',
                'flag' => 'cmsplugin.create',
                'parent_flag' => 'cmsplugin.list',
            ],
            [
                'name' => 'Edit',
                'flag' => 'cmsplugin.edit',
                'parent_flag' => 'cmsplugin.list',
            ],
            [
                'name' => 'Delete',
                'flag' => 'cmsplugin.delete',
                'parent_flag' => 'cmsplugin.list',
            ]
        ];
    }

    /**
     * @author Sang Nguyen
     */
    public static function activate()
    {
        Permission::registerPermission(self::permissions());
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/cmsplugin/database/migrations',
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
        Permission::removePermission(self::permissions());
        Schema::dropIfExists('cmsplugin');
    }
}