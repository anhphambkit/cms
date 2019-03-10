<?php

namespace Core\Media\Providers;

use Core\Media\Facades\BMediaFacade;

use Core\Media\Models\MediaSetting;
use Core\Media\Models\MediaFolder;
use Core\Media\Models\MediaShare;
use Core\Media\Models\MediaFile;
use Core\User\Models\User;

use Core\Media\Repositories\Interfaces\MediaSettingRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaSettingRepositories;
use Core\Media\Repositories\Cache\CacheMediaSettingRepositories;

use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaFileRepositories;
use Core\Media\Repositories\Cache\CacheMediaFileRepositories;

use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaFolderRepositories;
use Core\Media\Repositories\Cache\CacheMediaFolderRepositories;

use Core\Media\Repositories\Interfaces\MediaShareRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaShareRepositories;
use Core\Media\Repositories\Cache\CacheMediaShareRepositories;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class MediaServiceProvider
 * @package Core\Media
 * @author TrinhLe
 */
class MediaServiceProvider extends ServiceProvider
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
        $this->reigsterRepositories();

        AliasLoader::getInstance()->alias('BMedia', BMediaFacade::class);
    }

    /**
     * Register list repo
     * @author TrinhLe
     */
    protected function reigsterRepositories()
    {
        if (setting('enable_cache_media', false)) {

            $this->app->singleton(MediaSettingRepositories::class, function () {
                return new CacheMediaSettingRepositories(new EloquentMediaSettingRepositories(new \Core\Media\Models\MediaSetting()));
            });

            $this->app->singleton(MediaFileRepositories::class, function () {
                return new CacheMediaFileRepositories(new EloquentMediaFileRepositories(new \Core\Media\Models\MediaFile()));
            });

            $this->app->singleton(MediaFolderRepositories::class, function () {
                return new CacheMediaFolderRepositories(new EloquentMediaFolderRepositories(new \Core\Media\Models\MediaFolder()));
            });

            $this->app->singleton(MediaShareRepositories::class, function () {
                return new CacheMediaShareRepositories(new EloquentMediaShareRepositories(new \Core\Media\Models\MediaShare()));
            });
            
        } else {

            $this->app->singleton(MediaSettingRepositories::class, function () {
                return new EloquentMediaSettingRepositories(new \Core\Media\Models\MediaSetting());
            });

            $this->app->singleton(MediaFileRepositories::class, function () {
                return new EloquentMediaFileRepositories(new \Core\Media\Models\MediaFile());
            });

            $this->app->singleton(MediaFolderRepositories::class, function () {
                return new EloquentMediaFolderRepositories(new \Core\Media\Models\MediaFolder());
            });

            $this->app->singleton(MediaShareRepositories::class, function () {
                return new EloquentMediaShareRepositories(new \Core\Media\Models\MediaShare());
            });
        }
    }

    /**
     * Boot the service provider.
     * @author TrinhLe
     */
    public function boot()
    {
       
    }
}
