<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Caches\CacheProductRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

class ProductServiceProvider extends ServiceProvider
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
            $this->app->singleton(ProductRepositories::class, function () {
                return new CacheProductRepositories(new EloquentProductRepositories(new \Plugins\Product\Models\Product()));
            });
        } else {
            $this->app->singleton(ProductRepositories::class, function () {
                return new EloquentProductRepositories(new \Core\User\Models\Product());
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
