<?php

namespace Plugins\Review\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Review\Repositories\Caches\CacheReviewRepositories;
use Plugins\Review\Repositories\Eloquent\EloquentReviewRepositories;
use Plugins\Review\Repositories\Interfaces\ReviewRepositories;
use Plugins\Review\Repositories\Interfaces\ReviewCommentRepositories;
use Plugins\Review\Repositories\Eloquent\EloquentReviewCommentRepositories;
use Plugins\Review\Repositories\Caches\CacheReviewCommentRepositories;

class ReviewServiceProvider extends ServiceProvider
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
            $this->app->singleton(ReviewRepositories::class, function () {
                return new CacheReviewRepositories(new EloquentReviewRepositories(new \Plugins\Review\Models\Review()));
            });
        } else {
            $this->app->singleton(ReviewRepositories::class, function () {
                return new EloquentReviewRepositories(new \Plugins\Review\Models\Review());
            });
        }

        if (setting('enable_cache', false)) {
            $this->app->singleton(ReviewCommentRepositories::class, function () {
                return new CacheReviewCommentRepositories(new EloquentReviewCommentRepositories(new \Plugins\Review\Models\Review()));
            });
        } else {
            $this->app->singleton(ReviewCommentRepositories::class, function () {
                return new EloquentReviewCommentRepositories(new \Plugins\Review\Models\ReviewComment());
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
