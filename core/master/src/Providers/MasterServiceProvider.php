<?php

namespace Core\Master\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Core\Master\Facades\ActionFacade;
use Core\Master\Facades\FilterFacade;

class MasterServiceProvider extends ServiceProvider
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
        $loader = AliasLoader::getInstance();
        $loader->alias('Action', ActionFacade::class);
        $loader->alias('Filter', FilterFacade::class);
    }
}