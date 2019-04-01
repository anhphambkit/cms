<?php

namespace Plugins\Productlookbook\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Productlookbook\Repositories\Caches\CacheProductlookbookRepositories;
use Plugins\Productlookbook\Repositories\Eloquent\EloquentProductlookbookRepositories;
use Plugins\Productlookbook\Repositories\Interfaces\ProductlookbookRepositories;

class ProductlookbookServiceProvider extends ServiceProvider
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
            $this->app->singleton(ProductlookbookRepositories::class, function () {
                return new CacheProductlookbookRepositories(new EloquentProductlookbookRepositories(new \Plugins\Productlookbook\Models\Productlookbook()));
            });
        } else {
            $this->app->singleton(ProductlookbookRepositories::class, function () {
                return new EloquentProductlookbookRepositories(new \Plugins\Productlookbook\Models\Productlookbook());
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
