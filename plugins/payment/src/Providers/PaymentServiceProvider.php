<?php

namespace Plugins\Payment\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Payment\Repositories\Caches\CachePaymentRepositories;
use Plugins\Payment\Repositories\Eloquent\EloquentPaymentRepositories;
use Plugins\Payment\Repositories\Interfaces\PaymentRepositories;
use Plugins\Payment\Services\PaypalCreditService;
use Plugins\Payment\Services\IPaypalCreditService;
use Plugins\Payment\Services\PaypalExpressService;
use Plugins\Payment\Services\IPaypalExpressService;
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

        $this->app->singleton(IPaypalCreditService::class, PaypalCreditService::class);
        $this->app->singleton(IPaypalExpressService::class, PaypalExpressService::class);
    }

    /**
     * @author TrinhLe
     */
    public function boot(){}
}
