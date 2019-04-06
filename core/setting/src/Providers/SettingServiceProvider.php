<?php

namespace Core\Setting\Providers;

use Core\Setting\Facades\SettingFacade;
use Core\Setting\Models\Setting as SettingModel;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Core\Setting\Repositories\Interfaces\SettingRepositories;
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

        if (setting('enable_cache', false)) {

            $this->app->singleton(SettingRepositories::class, function () {
                return new CacheSettingRepositories(new EloquentSettingRepositories(new \Core\Setting\Models\Setting()));
            });
            
        } else {

            $this->app->singleton(SettingRepositories::class, function () {
                return new EloquentSettingRepositories(new \Core\Setting\Models\Setting());
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
