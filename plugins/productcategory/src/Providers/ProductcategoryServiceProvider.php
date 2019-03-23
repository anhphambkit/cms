<?php

namespace Plugins\Productcategory\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Productcategory\Repositories\Caches\CacheProductcategoryRepositories;
use Plugins\Productcategory\Repositories\Eloquent\EloquentProductcategoryRepositories;
use Plugins\Productcategory\Repositories\Interfaces\ProductcategoryRepositories;

class ProductcategoryServiceProvider extends ServiceProvider
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
            $this->app->singleton(ProductcategoryRepositories::class, function () {
                return new CacheProductcategoryRepositories(new EloquentProductcategoryRepositories(new \Plugins\Productcategory\Models\Productcategory()));
            });
        } else {
            $this->app->singleton(ProductcategoryRepositories::class, function () {
                return new EloquentProductcategoryRepositories(new \Plugins\Productcategory\Models\Productcategory());
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
