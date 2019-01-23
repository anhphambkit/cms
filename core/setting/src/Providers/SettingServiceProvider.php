<?php

namespace Core\Setting\Providers;

use Core\Setting\Facades\SettingFacade;
use Core\Setting\Models\Setting as SettingModel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Core\Setting\Repositories\SettingRepositories;
use Core\Setting\Repositories\Eloquent\EloquentSettingRepositories;
use Core\Setting\Repositories\Cache\CacheSettingRepositories;

class SettingServiceProvider extends ServiceProvider
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
        AliasLoader::getInstance()->alias('Setting', SettingFacade::class);

        // $this->app->singleton(SettingRepositories::class, function () {
        //     $repository = new EloquentSettingRepositories();

        //     if (! config("app.cache")) {
        //         return $repository;
        //     }
        //     return new CacheSettingRepositories($repository);
        // });
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
