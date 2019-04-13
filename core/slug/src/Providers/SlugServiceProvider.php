<?php

namespace Core\Slug\Providers;

use Core\Slug\Models\Slug;
use Illuminate\Support\ServiceProvider;
use Core\Slug\Repositories\Interfaces\SlugRepositories;
use Core\Slug\Repositories\Eloquent\EloquentSlugRepositories;

class SlugServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Trinh Le
     */
    public function register()
    {
       $this->app->singleton(SlugRepositories::class, function () {
            return new EloquentSlugRepositories(new Slug());
        });

    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
