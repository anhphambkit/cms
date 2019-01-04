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

		$this->app->register(AssetServiceProvider::class);
		$this->app->register(StylistServiceProvider::class);
		$this->app->register(MasterServiceProvider::class);
		$this->app->register(SettingServiceProvider::class);
		$this->app->singleton(ExceptionHandler::class, Handler::class);

		#============Assets============#
		$this->registerComposers();
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
		
		$this->app->register(CommandServiceProvider::class);
		$this->app->register(RouteServiceProvider::class);
		$this->app->register(ThemeServiceProvider::class);

		$this->bootHelperThemeOption();
	}

	/**
	 * Init option for theme
	 * @author TrinhLe
	 */
	protected function bootHelperThemeOption()
	{
		if (check_database_connection()) {
			if($this->inAdministration())
			{
				$helpers = base_path() . DIRECTORY_SEPARATOR . 'Themes' . DIRECTORY_SEPARATOR . 'functions';
            	Helper::autoloadHelpers($helpers);
			}
        }
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
	 * Register view composer assets
	 * @author TrinhLe
	 */
	protected function registerComposers()
	{
		view()->composer('layouts.master', \Core\Theme\Composers\AssetsViewComposer::class);
	}
}
