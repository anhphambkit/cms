<?php
/**
 * Created by PhpStorm.
 * User: trinhle
 * Date: 05/04/19
 * Time: 23:28
 */
return [
    'client_id' => env('PAYPAL_CLIENT_ID', 'AVuLC5r2263UDgf5gZQqAI3phewxrlBPaPQelgP1zaNRAJocLa0igEHtEiAUryK-Fa1u9M1Ck1GELRRA'),
    'secret' => env('PAYPAL_SECRET', 'EOxH4A_Nz5ZEDijLIayeYS1kq9PZfKh5UCozJol_82cAWnNuP2j8HS54PAQEr4P6ABDcdeCFL5AzeU8h'),
    'settings' => [
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.logEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ],
    'currency' => 'USD',
];