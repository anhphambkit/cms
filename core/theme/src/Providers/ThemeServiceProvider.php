<?php

namespace Core\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Core\Theme\Facades\ThemeOptionFacade;

class ThemeServiceProvider extends ServiceProvider
{
	/**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Register the service provider.
     * @author TrinhLe
     * @return void
     */
    public function register()
    {
        $this->registerAllThemes();
        $this->setActiveTheme();
        $this->registerFacades();
    }

    /**
     * Register facades for theme assets
     * @author TrinhLe
     */
    protected function registerFacades()
    {
        AliasLoader::getInstance()->alias('ThemeOption', ThemeOptionFacade::class);
    }

    /**
     * Set the active theme based on the settings
     * @author TrinhLe
     */
    protected function setActiveTheme()
    {
        if ($this->app->runningInConsole()) {
            return;
        }
        
        if ($this->inAdministration()) {
        	
        	$themeName = setting('theme_admin', 'KOSMO');
            return $this->app['stylist']->activate($themeName, true);
        }

        $themeName = setting('theme_frontend', 'KOSMO');
        return $this->app['stylist']->activate($themeName, true);
    }

    /**
     * Check if we are in the administration
     * @author TrinhLe
     * @return bool
     */
    protected function inAdministration()
    {
        $segment = 1;
        return $this->app['request']->segment($segment) === config('core-base.cms.router-prefix.admin');
    }

    /**
     * Register all themes with activating them
     * @author TrinhLe
     */
    protected function registerAllThemes()
    {
        $functionPath = [base_path('/Themes/functions')];

        $directories = $this->app['files']->directories(config('stylist.themes.paths', [base_path('/Themes')])[0]);
        
        $directories = array_diff($directories,$functionPath);

        foreach ($directories as $directory) {
            $this->app['stylist']->registerPath($directory);
        }
    }
}
