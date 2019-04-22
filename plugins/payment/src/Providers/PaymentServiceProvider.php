<?php

namespace Plugins\Payment\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Payment\Repositories\Caches\CachePaymentRepositories;
use Plugins\Payment\Repositories\Eloquent\EloquentPaymentRepositories;
use Plugins\Payment\Repositories\Interfaces\PaymentRepositories;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author TrinhLe
     */
    public function register()
    {
        if (setting('enable_cache', false)) {
            $this->app->singleton(PaymentRepositories::class, function () {
                return new CachePaymentRepositories(new EloquentPaymentRepositories(new \Plugins\Payment\Models\Payment()));
            });
        } else {
            $this->app->singleton(PaymentRepositories::class, function () {
                return new EloquentPaymentRepositories(new \Plugins\Payment\Models\Payment());
            });
        }
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
