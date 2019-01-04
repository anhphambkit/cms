<?php

namespace Core\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Core\Theme\Foundation\Asset\Manager\CmsAssetManager;
use Core\Theme\Foundation\Asset\Manager\AssetManager;
use Core\Theme\Foundation\Asset\Pipeline\CmsAssetPipeline;
use Core\Theme\Foundation\Asset\Pipeline\AssetPipeline;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->bindAssetClasses();
    }

    /**
     * Bind classes related to assets
     */
    private function bindAssetClasses()
    {
        $this->app->singleton(AssetManager::class, function () {
            return new CmsAssetManager();
        });

        $this->app->singleton(AssetPipeline::class, function ($app) {
            return new CmsAssetPipeline($app[AssetManager::class]);
        });
    }
}
