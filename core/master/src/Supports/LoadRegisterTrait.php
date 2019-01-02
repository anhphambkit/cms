<?php
declare(strict_types=1);

namespace Core\Master\Supports;
use Illuminate\Support\Facades\Cache;
use File;

trait LoadRegisterTrait
{   
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
                    ], 'config');
                }else
                {
                     $this->publishes([
                        $config => config_path(strtolower("plugins/$package/$fileName") . '.php'),
                    ], 'config');
                }
            }
        }
    }

    /**
     * Get path of the give file name in the given package
     * @param string $package
     * @param string $file
     * @return string
     */
    private function getPackageConfigFilePath($package, $file)
    {
        return $this->getPackagePath($package) . "/Config/$file.php";
    }

    /**
     * @param $package
     * @return string
     */
    private function getPackagePath($package)
    {
        return base_path('Packages' . DIRECTORY_SEPARATOR . ucfirst($package));
    }

    /**
     * Description
     * @author TrinhLe
     * @param type|null $pathSource 
     * @return array
     */
    protected function loadPackages($pathSource = null) : array
    {
        if(!$pathSource)
            return array();

        return Cache::tags('loadPackages')->remember("{$pathSource}", 120, function() use ($pathSource){
            return loadPackages($pathSource);
        });
    }
}