<?php 
namespace Core\Base\Providers;
use Illuminate\Support\ServiceProvider;
use Core\Master\Supports\Helper;
use Core\Master\Providers\MasterServiceProvider;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Core\Base\Exceptions\Handler;
use Core\Master\Supports\LoadRegisterTrait;

class BaseServiceProvider extends ServiceProvider
{	
	use LoadRegisterTrait;
	/**
     * {@inheritDoc}
     */
    const SOURCE_VIEWS = '/../resources/views';

    /**
     * {@inheritDoc}
     */
    const SOURCE_TRANSLATES = '/../resources/lang';

    /**
     * {@inheritDoc}
     */
    const SOURCE_CONFIGS = '/../config';

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

		$this->app->register(MasterServiceProvider::class);

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
		
		$this->app->register(CommandServiceProvider::class);
		$this->app->register(RouteServiceProvider::class);
	}
}
