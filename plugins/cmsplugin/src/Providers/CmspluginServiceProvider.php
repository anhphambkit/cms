<?php

namespace Plugins\Cmsplugin\Providers;

use Plugins\Cmsplugin\Models\Cmsplugin;
use Illuminate\Support\ServiceProvider;
use Plugins\Cmsplugin\Repositories\Caches\CmspluginCacheDecorator;
use Plugins\Cmsplugin\Repositories\Eloquent\CmspluginRepository;
use Plugins\Cmsplugin\Repositories\Interfaces\CmspluginInterface;
use Core\Master\Services\Cache\Cache;
use Core\Base\Supports\Helper;

class CmspluginServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Sang Nguyen
     */
    public function register()
    {
        if (setting('enable_cache', false)) {
            $this->app->singleton(CmspluginInterface::class, function () {
                return new CmspluginCacheDecorator(new CmspluginRepository(new Cmsplugin()), new Cache($this->app['cache'], CmspluginRepository::class));
            });
        } else {
            $this->app->singleton(CmspluginInterface::class, function () {
                return new CmspluginRepository(new Cmsplugin());
            });
        }
    }

    /**
     * @author Sang Nguyen
     */
    public function boot()
    {
        
    }
}
