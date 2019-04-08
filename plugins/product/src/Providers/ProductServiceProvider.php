<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Caches\CacheBrandRepositories;
use Plugins\Product\Repositories\Caches\CacheProductRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentBrandRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductRepositories;
use Plugins\Product\Repositories\Interfaces\BrandRepositories;
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

            $this->app->singleton(BrandRepositories::class, function () {
                return new CacheBrandRepositories(new EloquentBrandRepositories(new \Plugins\Product\Models\Brand()));
            });
        } else {
            $this->app->singleton(ProductRepositories::class, function () {
                return new EloquentProductRepositories(new \Plugins\Product\Models\Product());
            });

            $this->app->singleton(BrandRepositories::class, function () {
                return new EloquentBrandRepositories(new \Plugins\Product\Models\Brand());
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
