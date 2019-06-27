<?php

namespace Core\SeoHelper\Providers;

use Core\Base\Supports\Helper;
use Core\SeoHelper\Contracts\SeoHelperContract;
use Core\SeoHelper\Facades\SeoHelperFacade;
use Core\SeoHelper\SeoHelper;
use Core\SeoHelper\SeoMeta;
use Core\SeoHelper\SeoOpenGraph;
use Core\SeoHelper\SeoTwitter;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Core\SeoHelper\Contracts\SeoMetaContract;
use Core\SeoHelper\Contracts\SeoOpenGraphContract;
use Core\SeoHelper\Contracts\SeoTwitterContract;
use Core\SeoHelper\Repositories\Interfaces\MetaBoxRepositories;
use Core\SeoHelper\Facades\MetaBoxFacade;
/**
 * Class SEOServiceProvider
 * @package Botble\SEO
 * @author TrinhLe
 * @since 02/12/2015 14:09 PM
 */
class SeoHelperServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Prefix support binding eloquent
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_ELOQUENT = 'Eloquent\\Eloquent';

    /**
     * Prefix support binding cache
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_CACHE = 'Caches\\Cache';

    /**
     * @author TrinhLe
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('MetaBox', MetaBoxFacade::class);

        register_repositories($this);
        $this->app->bind(SeoMetaContract::class, SeoMeta::class);
        $this->app->bind(SeoHelperContract::class, SeoHelper::class);
        $this->app->bind(SeoOpenGraphContract::class, SeoOpenGraph::class);
        $this->app->bind(SeoTwitterContract::class, SeoTwitter::class);

        AliasLoader::getInstance()->alias('SeoHelper', SeoHelperFacade::class);
    }

    /**
     * @return array
     */
    public function getRespositories():array
    {
        return [
            MetaBoxRepositories::class => \Core\SeoHelper\Models\MetaBox::class,
        ];
    }

    /**
     * Boot the service provider.
     * @author TrinhLe
     */
    public function boot()
    {
        $this->app->register(HookServiceProvider::class);
    }
}
