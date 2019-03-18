<?php
declare(strict_types=1);

namespace Core\Master\Supports;
use Illuminate\Support\Facades\Cache;
use File;

trait LoadRegisterTrait
{   
    /**
     * prefix cache tag package provider
     * @var string
     */
    protected $entityCache = "cache-packages";

    /**
     * Load all view for packages or plugins
     * @author TrinhLe
     */
    protected function cmsLoadViews()
    {
        $sources = $this->loadPackages(SOURCE_VIEWS);
        foreach ($sources as $group => $dir) {
            # code...
            $this->loadViewsFrom($dir, $group);
        }
    }

    /**
     * Load all view for packages or plugins
     * @author TrinhLe
     */
	protected function cmsLoadTranslates()
    {
        $sources = $this->loadPackages(SOURCE_TRANSLATES);

        foreach ($sources as $group => $dir) {
            # code...
            $this->loadTranslationsFrom($dir, $group);
            $this->loadJsonTranslationsFrom($dir, $group);
        }
    }

    /**
     * Load all config for packages or plugins
     * @author TrinhLe
     * @return mixed
     */
    protected function cmsLoadConfigs()
    {
        $sources = $this->loadPackages(SOURCE_CONFIGS);

        foreach ($sources as $group => $dir) {

            $configs = File::glob($dir . '/*.php');

            foreach ($configs as $config) {

                $fileName = pathinfo($config, PATHINFO_FILENAME);

                $this->mergeConfigFrom($config, "{$group}.{$fileName}");

                $this->publishConfig($group, $config, $fileName);
            }
        }
    }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param string $module
     * @param string $fileName
     * @author TrinhLe
     */
    protected function publishConfig($group, $config, $fileName)
    {
        if (app()->environment() !== 'testing') 
        {
            if ($this->app->runningInConsole()) {
                   
                $package = getPackageNamespace($group);
                
                if(isCorePackage($group))
                {
                    $this->publishes([
                        $config => config_path(strtolower("core/$package/$fileName") . '.php'),
                    ], 'config-packages');
                }else
                {
                     $this->publishes([
                        $config => config_path(strtolower("plugins/$package/$fileName") . '.php'),
                    ], 'config-packages');
                }
            }
        }
    }

    /**
     * Pushlish data system
     * @author TrinhLe
     */
    protected function pushlishData()
    {
        if (app()->environment() !== 'testing') 
        {
            if ($this->app->runningInConsole()) {
                   
                $sources = $this->loadPackages(SOURCE_DATAS);

                foreach ($sources as $group => $dir) {
                    # publishes file export
                    $this->publishes([ $dir => storage_path('app/public')], 'system-data');
                }
            }
        }
    }

    /**
     * Description
     * @author TrinhLe
     */
    protected function publishMigration()
    {
        if (app()->environment() !== 'testing') 
        {
            if ($this->app->runningInConsole()) {

                $sources = $this->loadPackages(SOURCE_MIGRATIONS);
                foreach ($sources as $group => $dir) {
                    $this->publishes([
                        $dir => database_path('migrations'),
                    ], 'cms-migrations');
                }
            }
        }
    }

    /**
     * Description
     * @author TrinhLe
     * @param type|string $pathSource 
     * @return array
     */
    protected function loadPackages(string $pathSource = '', bool $formatNamespace = true) : array
    {
        return Cache::tags($this->entityCache)->remember("{$pathSource}", 120, function() use ($pathSource, $formatNamespace){
            return loadPackages($pathSource, $formatNamespace);
        });
    }

    /**
     * Description
     * @author TrinhLe
     * @param type|string $pathSource 
     * @return array
     */
    protected function loadPackageAvailable() : array
    {
        return Cache::tags($this->entityCache)->remember("loadPackageAvailable", 120, function(){
            return loadPackageAvailable();
        });
    }

    /**
     * Description
     * @author TrinhLe
     * @param type|string $pathSource 
     * @return array
     */
    protected function loadPluginAvailable()
    {
        return Cache::tags($this->entityCache)->remember("loadPluginAvailable", 120, function(){
            return getAllPlugins(1) ?? [];
        });
    }

    /**
     * FlushAll cache
     * @author  TrinhLe
     */
    protected function flushAllCacheProvider()
    {
        return Cache::tags($this->entityCache)->flush();
    }
}