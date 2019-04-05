<?php

namespace Plugins\Productcategory;

use Artisan;
use Schema;
class Plugin
{

    /**
     * @author TrinhLE
     */
    public static function activate()
    {
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/productcategory/database/migrations',
        ]);
    }

    /**
     * @author TrinhLE
     */
    public static function deactivate()
    {

    }

    /**
     * @author TrinhLE
     */
    public static function remove()
    {
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/productcategory/database/migrations',
        ]);
    }
}