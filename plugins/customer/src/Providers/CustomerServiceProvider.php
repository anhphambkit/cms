<?php

namespace Plugins\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Customer\Repositories\Caches\CacheCustomerRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Middlewares\RedirectIfNotCustomer;
use Plugins\Customer\Middlewares\RedirectIfCustomer;
use Plugins\Customer\Models\Customer;
use Illuminate\View\View;

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
        config([
            'auth.guards.customer'     => [
                'driver'   => 'session',
                'provider' => 'customers',
            ],
            'auth.providers.customers' => [
                'driver' => 'eloquent',
                'model'  => Customer::class,
            ],
            'auth.passwords.customers' => [
                'provider' => 'customers',
                'table'    => 'customers_password_resets',
                'expire'   => 60,
            ],
            'auth.guards.member-api' => [
                'driver'   => 'passport',
                'provider' => 'customers',
            ],
        ]);

        /**
         * @var Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('customer', RedirectIfNotCustomer::class);
        $router->aliasMiddleware('customer.guest', RedirectIfCustomer::class);


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
        view()->composer('*', \Plugins\Customer\Composers\CurrentCustomerComposer::class);
    }
}
