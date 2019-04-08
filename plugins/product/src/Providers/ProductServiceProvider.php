<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Caches\CacheBrandRepositories;
use Plugins\Product\Repositories\Caches\CacheProductColorRepositories;
use Plugins\Product\Repositories\Caches\CacheProductRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentBrandRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductColorRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductRepositories;
use Plugins\Product\Repositories\Interfaces\BrandRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
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
                return new CacheBrandRepositories(new EloquentBrandRepositories(new \Plugins\Product\Models\ProductBrand()));
            });

            $this->app->singleton(ProductColorRepositories::class, function () {
                return new CacheProductColorRepositories(new EloquentProductColorRepositories(new \Plugins\Product\Models\ProductColor()));
            });
        } else {
            $this->app->singleton(ProductRepositories::class, function () {
                return new EloquentProductRepositories(new \Plugins\Product\Models\Product());
            });

            $this->app->singleton(BrandRepositories::class, function () {
                return new EloquentBrandRepositories(new \Plugins\Product\Models\ProductBrand());
            });

            $this->app->singleton(ProductColorRepositories::class, function () {
                return new EloquentProductColorRepositories(new \Plugins\Product\Models\ProductColor());
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
