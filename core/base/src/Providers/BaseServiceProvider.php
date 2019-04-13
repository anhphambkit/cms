<?php 
namespace Core\Base\Providers;
use Illuminate\Support\ServiceProvider;
use Core\Master\Supports\Helper;
use Core\Master\Providers\MasterServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Core\Base\Exceptions\Handler;
use Core\Master\Supports\LoadRegisterTrait;
use FloatingPoint\Stylist\StylistServiceProvider;
use Core\Setting\Providers\SettingServiceProvider;
use Core\Theme\Providers\AssetServiceProvider;
use Core\Theme\Providers\ThemeServiceProvider;
use Core\User\Providers\UserServiceProvider;
use Core\Media\Providers\MediaServiceProvider;
use Core\Slug\Providers\SlugServiceProvider;
use Event;
use Illuminate\Routing\Events\RouteMatched;

# Plugin 
use Core\Base\Repositories\Interfaces\PluginRepositories;
use Core\Base\Repositories\Eloquent\EloquentPluginRepositories;
use Core\Base\Repositories\Cache\CachePluginRepositories;

class BaseServiceProvider extends ServiceProvider
{	
	use LoadRegisterTrait;

	/**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
	 * Register anothers services
	 * @return type
	 */
	public function register()
	{
		Helper::autoloadHelpers();
		
		/**
         * @var Router $router
         */
        $router = $this->app['router'];

		$this->app->register(AssetServiceProvider::class);
		$this->app->register(StylistServiceProvider::class);
		$this->app->register(MasterServiceProvider::class);
		$this->app->register(SettingServiceProvider::class);
		
		$this->app->singleton(ExceptionHandler::class, Handler::class);

		$this->app->singleton(PluginRepositories::class, function () {
            $repository = new EloquentPluginRepositories(new \Core\Base\Models\Plugin());

            if (! setting('enable_cache', false)) {
                return $repository;
            }
            return new CachePluginRepositories($repository);
        });

        $this->app->register(PluginServiceProvider::class);
	}
    
	/**
	 * Binding containers
	 * @return type
	 */
	public function boot()
	{	
		# load config important use helper.
		$this->cmsLoadTranslates();
		$this->cmsLoadConfigs();
		$this->cmsLoadViews();
		$this->publishMigration();
		$this->pushlishData();
		$this->publishesAssetRegister();

		$this->app->register(CommandServiceProvider::class);
		$this->app->register(BreadcrumbsServiceProvider::class);
		$this->app->register(RouteServiceProvider::class);
		$this->app->register(ThemeServiceProvider::class);
		$this->app->register(FormServiceProvider::class);
		$this->app->register(UserServiceProvider::class);
		$this->app->register(MediaServiceProvider::class);
		$this->app->register(SlugServiceProvider::class);
		
        add_filter(DASHBOARD_FILTER_MENU_NAME, [\Core\Dashboard\Hooks\DashboardMenuHook::class, 'renderMenuDashboard']);
        add_filter(BASE_FILTER_GET_LIST_DATA, [$this, 'addLanguageColumn'], 50, 2);
        
        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->loadRegisterMenus();
        });
	}

	/**
     * @param $data
     * @param $screen
     * @return mixed
     * @author Sang Nguyen
     */
    public function addLanguageColumn($data, $screen)
    {
        return $data;
    }
}
