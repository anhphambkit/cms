<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Caches\CacheProductCategoryRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Caches\CacheBrandRepositories;
use Plugins\Product\Repositories\Caches\CacheBusinessTypeRepositories;
use Plugins\Product\Repositories\Caches\CacheProductCollectionRepositories;
use Plugins\Product\Repositories\Caches\CacheProductColorRepositories;
use Plugins\Product\Repositories\Caches\CacheProductMaterialRepositories;
use Plugins\Product\Repositories\Caches\CacheProductRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentBrandRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentBusinessTypeRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCollectionRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductColorRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductMaterialRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductRepositories;
use Plugins\Product\Repositories\Interfaces\BrandRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;

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

            $this->app->singleton(BrandRepositories::class, function () {
                return new CacheBrandRepositories(new EloquentBrandRepositories(new \Plugins\Product\Models\ProductBrand()));
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
        }
    }

    /**
     * @author AnhPham
     */
    public function boot()
    {
        
    }
}
