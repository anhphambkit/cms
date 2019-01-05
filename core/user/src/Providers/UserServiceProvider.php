<?php

namespace Core\User\Providers;
use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Illuminate\Support\Facades\Auth;
use Core\User\Repositories\Interfaces\Authentication;
use Core\User\Repositories\Eloquent\EloquentAuthentication;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Repositories\Eloquent\UserRepository;
use Core\User\Guards\Sentinel;
use Core\Base\Providers\CmsServiceProvider as CoreServiceProvider;

/**
 * Class UserServiceProvider
 * @package Core\User
 */
class UserServiceProvider extends CoreServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listens = [
        \Core\User\Events\AuditHandlerEvent::class => [
            \Core\User\Listeners\AuditHandlerListener::class,
        ],
    ];

    /**
     * register
     */
    public function register()
    {
        # reigster driver user # 
        $this->app->register(SentinelServiceProvider::class);

        # binding basic services of user.
        $this->app->bind(
            Authentication::class,
            EloquentAuthentication::class
        );

        $this->app->singleton(UserInterface::class, function () {
            return new UserRepository(new \Core\User\Models\User());
        });

        $this->registerEvents();
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        # Important register guard
        Auth::extend('sentinel-guard', function () {
            return new Sentinel();
        });

        $this->app->register(HookServiceProvider::class);
    }
}
