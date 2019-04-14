<?php

namespace Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Blog\Repositories\Caches\CacheBlogRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentBlogRepositories;
use Plugins\Blog\Repositories\Interfaces\BlogRepositories;

use Plugins\Blog\Repositories\Interfaces\PostRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentPostRepositories;
use Plugins\Blog\Repositories\Cache\CachePostRepositories;

use Plugins\Blog\Repositories\Interfaces\CategoryRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentCategoryRepositories;
use Plugins\Blog\Repositories\Cache\CacheCategoryRepositories;

use Plugins\Blog\Repositories\Interfaces\TagRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentTagRepositories;
use Plugins\Blog\Repositories\Cache\CacheTagRepositories;

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

            $this->app->singleton(PostRepositories::class, function () {
                return new CachePostRepositories(new EloquentPostRepositories(new \Plugins\Blog\Models\Post()));
            });

            $this->app->singleton(CategoryRepositories::class, function () {
                return new CacheCategoryRepositories(new EloquentCategoryRepositories(new \Plugins\Blog\Models\Category()));
            });

            $this->app->singleton(TagRepositories::class, function () {
                return new CacheTagRepositories(new EloquentTagRepositories(new \Plugins\Blog\Models\Tag()));
            });
        } else {
            $this->app->singleton(BlogRepositories::class, function () {
                return new EloquentBlogRepositories(new \Plugins\Blog\Models\Blog());
            });

            $this->app->singleton(PostRepositories::class, function () {
                return new EloquentPostRepositories(new \Plugins\Blog\Models\Post());
            });

            $this->app->singleton(CategoryRepositories::class, function () {
                return new EloquentCategoryRepositories(new \Plugins\Blog\Models\Category());
            });

            $this->app->singleton(TagRepositories::class, function () {
                return new EloquentTagRepositories(new \Plugins\Blog\Models\Tag());
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