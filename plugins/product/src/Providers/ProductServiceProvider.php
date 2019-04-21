<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Caches\CacheLookBookRepositories;
use Plugins\Product\Repositories\Caches\CacheProductCategoryRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentLookBookRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Caches\CacheManufacturerRepositories;
use Plugins\Product\Repositories\Caches\CacheBusinessTypeRepositories;
use Plugins\Product\Repositories\Caches\CacheProductCollectionRepositories;
use Plugins\Product\Repositories\Caches\CacheProductColorRepositories;
use Plugins\Product\Repositories\Caches\CacheProductMaterialRepositories;
use Plugins\Product\Repositories\Caches\CacheProductRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentManufacturerRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentBusinessTypeRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCollectionRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductColorRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductMaterialRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductRepositories;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Services\Implement\ImplementProductCategoryServices;
use Plugins\Product\Services\Implement\ImplementProductServices;
use Plugins\Product\Services\ProductCategoryServices;
use Plugins\Product\Services\ProductServices;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author AnhPham
     */
    public function register()
    {
        if (setting('enable_cache', false)) {
            $this->app->singleton(ProductRepositories::class, function () {
                return new CacheProductRepositories(new EloquentProductRepositories(new \Plugins\Product\Models\Product()));
            });

            $this->app->singleton(manufacturerRepositories::class, function () {
                return new CacheManufacturerRepositories(new EloquentManufacturerRepositories(new \Plugins\Product\Models\ProductManufacturer()));
            });

            $this->app->singleton(ProductColorRepositories::class, function () {
                return new CacheProductColorRepositories(new EloquentProductColorRepositories(new \Plugins\Product\Models\ProductColor()));
            });

            $this->app->singleton(ProductCollectionRepositories::class, function () {
                return new CacheProductCollectionRepositories(new EloquentProductCollectionRepositories(new \Plugins\Product\Models\ProductCollection()));
            });

            $this->app->singleton(ProductMaterialRepositories::class, function () {
                return new CacheProductMaterialRepositories(new EloquentProductMaterialRepositories(new \Plugins\Product\Models\ProductMaterial()));
            });

            $this->app->singleton(BusinessTypeRepositories::class, function () {
                return new CacheBusinessTypeRepositories(new EloquentBusinessTypeRepositories(new \Plugins\Product\Models\ProductBusinessType()));
            });

            $this->app->singleton(ProductCategoryRepositories::class, function () {
                return new CacheProductCategoryRepositories(new EloquentProductCategoryRepositories(new \Plugins\Product\Models\ProductCategory()));
            });

            $this->app->singleton(LookBookRepositories::class, function () {
                return new CacheLookBookRepositories(new EloquentLookBookRepositories(new \Plugins\Product\Models\LookBook()));
            });

        } else {
            $this->app->singleton(ProductRepositories::class, function () {
                return new EloquentProductRepositories(new \Plugins\Product\Models\Product());
            });

            $this->app->singleton(manufacturerRepositories::class, function () {
                return new EloquentManufacturerRepositories(new \Plugins\Product\Models\ProductManufacturer());
            });

            $this->app->singleton(ProductColorRepositories::class, function () {
                return new EloquentProductColorRepositories(new \Plugins\Product\Models\ProductColor());
            });

            $this->app->singleton(ProductCollectionRepositories::class, function () {
                return new EloquentProductCollectionRepositories(new \Plugins\Product\Models\ProductCollection());
            });

            $this->app->singleton(ProductMaterialRepositories::class, function () {
                return new EloquentProductMaterialRepositories(new \Plugins\Product\Models\ProductMaterial());
            });

            $this->app->singleton(BusinessTypeRepositories::class, function () {
                return new EloquentBusinessTypeRepositories(new \Plugins\Product\Models\ProductBusinessType());
            });

            $this->app->singleton(ProductCategoryRepositories::class, function () {
                return new EloquentProductCategoryRepositories(new \Plugins\Product\Models\ProductCategory());
            });

            $this->app->singleton(LookBookRepositories::class, function () {
                return new EloquentLookBookRepositories(new \Plugins\Product\Models\LookBook());
            });
        }

        $this->app->singleton(ProductServices::class, ImplementProductServices::class);
        $this->app->singleton(ProductCategoryServices::class, ImplementProductCategoryServices::class);
    }

    /**
     * @author AnhPham
     */
    public function boot()
    {
        
    }
}
