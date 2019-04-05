<?php

namespace Plugins\Product;

use Artisan;
use Schema;
class Plugin
{
    /**
     * @author Trinh Le
     */
    public static function activate()
    {
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
        ]);
    }

    /**
     * @author Trinh Le
     */
    public static function deactivate()
    {

    }

    /**
     * @author Trinh Le
     */
    public static function remove()
    {
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
        ]);
    }
}