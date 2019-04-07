<?php

namespace Plugins\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Customer\Repositories\Caches\CacheCustomerRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;

class CustomerServiceProvider extends ServiceProvider
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
            $this->app->singleton(CustomerRepositories::class, function () {
                return new CacheCustomerRepositories(new EloquentCustomerRepositories(new \Plugins\Customer\Models\Customer()));
            });
        } else {
            $this->app->singleton(CustomerRepositories::class, function () {
                return new EloquentCustomerRepositories(new \Plugins\Customer\Models\Customer());
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
