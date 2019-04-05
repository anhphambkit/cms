<?php

namespace Plugins\Productlookbook;

use Artisan;
use Schema;

class Plugin
{
    /**
     * @author TrinhLe
     */
    public static function activate()
    {
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/productlookbook/database/migrations',
        ]);
    }

    /**
     * @author TrinhLe
     */
    public static function deactivate()
    {

    }

    /**
     * @author TrinhLe
     */
    public static function remove()
    {
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/productlookbook/database/migrations',
        ]);
    }
}