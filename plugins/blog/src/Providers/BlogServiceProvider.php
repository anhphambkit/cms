<?php

namespace Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Blog\Repositories\Caches\CacheBlogRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentBlogRepositories;
use Plugins\Blog\Repositories\Interfaces\BlogRepositories;

class BlogServiceProvider extends ServiceProvider
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
            $this->app->singleton(BlogRepositories::class, function () {
                return new CacheBlogRepositories(new EloquentBlogRepositories(new \Plugins\Blog\Models\Blog()));
            });
        } else {
            $this->app->singleton(BlogRepositories::class, function () {
                return new EloquentBlogRepositories(new \Plugins\Blog\Models\Blog());
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
