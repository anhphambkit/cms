<?php

namespace Plugins\Cart\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Cart\Repositories\Caches\CacheCartRepositories;
use Plugins\Cart\Repositories\Eloquent\EloquentCartRepositories;
use Plugins\Cart\Repositories\Interfaces\CartRepositories;
use Plugins\Cart\Services\CartServices;
use Plugins\Cart\Services\Implement\ImplementCartServices;

class CartServiceProvider extends ServiceProvider
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
            $this->app->singleton(CartRepositories::class, function () {
                return new CacheCartRepositories(new EloquentCartRepositories(new \Plugins\Cart\Models\Cart()));
            });
        } else {
            $this->app->singleton(CartRepositories::class, function () {
                return new EloquentCartRepositories(new \Plugins\Cart\Models\Cart());
            });
        }

        $this->app->singleton(CartServices::class, ImplementCartServices::class);
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
