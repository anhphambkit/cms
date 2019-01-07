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
use Core\Base\Middlewares\StartSession;
use Core\Base\Events\SessionStarted;
use Event;

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

        $router->pushMiddlewareToGroup('web', StartSession::class);

		$this->app->register(AssetServiceProvider::class);
		$this->app->register(StylistServiceProvider::class);
		$this->app->register(MasterServiceProvider::class);
		$this->app->register(SettingServiceProvider::class);
		$this->app->register(UserServiceProvider::class);
		
		$this->app->singleton(ExceptionHandler::class, Handler::class);
	}
    
	/**
	 * Binding containers
	 * @return type
	 */
	public function boot()
	{	
		# load config important use helper.
		$this->cmsLoadConfigs();
		$this->cmsLoadViews();
		$this->cmsLoadTranslates();
		$this->publishMigration();
		$this->pushlishData();
		
		$this->app->register(CommandServiceProvider::class);
		$this->app->register(RouteServiceProvider::class);
		$this->app->register(ThemeServiceProvider::class);

        add_filter(DASHBOARD_FILTER_MENU_NAME, [\Core\Dashboard\Hooks\DashboardMenuHook::class, 'renderMenuDashboard']);

        Event::listen(SessionStarted::class, function () {
            dashboard_menu()->loadRegisterMenus();
        });
	}
}
