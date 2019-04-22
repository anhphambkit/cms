<?php

namespace Plugins\Payment;

use Artisan;
use Core\Master\Supports\PermissionCommand;
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
            '--path' => 'plugins/payment/database/migrations',
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
            '--path' => 'plugins/payment/database/migrations',
        ]);
    }
}