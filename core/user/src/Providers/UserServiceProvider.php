<?php

namespace Core\User\Providers;
use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Illuminate\Support\Facades\Auth;
use Core\User\Repositories\Interfaces\Authentication;
use Core\User\Repositories\Eloquent\EloquentAuthentication;

#User
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Repositories\Eloquent\UserRepository;
#Role
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Caches\RoleCacheDecorator;
use Core\User\Repositories\Eloquent\RoleRepository;
use Core\User\Services\Excute\RoleServiceExcute;
use Core\User\Services\Interfaces\RoleServiceInterface;

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

        $this->reigsterServices();
        $this->reigsterRepositories();
        $this->registerEvents();
    }

    /**
     * Register list services
     * @return type
     */
    protected function reigsterServices(){
        $this->app->bind(
            RoleServiceInterface::class,
            RoleServiceExcute::class
        );
    }

    /**
     * Register list repo
     * @author TrinhLe
     */
    protected function reigsterRepositories()
    {
        # binding basic services of user.
        $this->app->bind(
            Authentication::class,
            EloquentAuthentication::class
        );

        $this->app->singleton(UserInterface::class, function () {
            return new UserRepository(new \Core\User\Models\User());
        });

        if (setting('enable_cache', false)) {

            // $this->app->singleton(PermissionInterface::class, function () {
            //     return new PermissionCacheDecorator(new PermissionRepository(new PermissionFlag()), new Cache($this->app['cache'], __CLASS__));
            // });

            $this->app->singleton(RoleInterface::class, function () {
                return new RoleCacheDecorator(new RoleRepository(new \Core\User\Models\Role()));
            });

            // $this->app->singleton(FeatureInterface::class, function () {
            //     return new FeatureCacheDecorator(new FeatureRepository(new Feature()), new Cache($this->app['cache'], __CLASS__));
            // });

            // $this->app->singleton(RoleUserInterface::class, function () {
            //     return new RoleUserCacheDecorator(new RoleUserRepository(new RoleUser()), new Cache($this->app['cache'], __CLASS__));
            // });

            // $this->app->singleton(RoleFlagInterface::class, function () {
            //     return new RoleFlagCacheDecorator(new RoleFlagRepository(new RoleFlag()), new Cache($this->app['cache'], __CLASS__));
            // });

            // $this->app->singleton(InviteInterface::class, function () {
            //     return new InviteCacheDecorator(new InviteRepository(new Invite()), new Cache($this->app['cache'], __CLASS__));
            // });
        } else {

            // $this->app->singleton(PermissionInterface::class, function () {
            //     return new PermissionRepository(new PermissionFlag());
            // });

            $this->app->singleton(RoleInterface::class, function () {
                return new RoleRepository(new \Core\User\Models\Role());
            });

            // $this->app->singleton(RoleUserInterface::class, function () {
            //     return new RoleUserRepository(new RoleUser());
            // });

            // $this->app->singleton(RoleFlagInterface::class, function () {
            //     return new RoleFlagRepository(new RoleFlag());
            // });

            // $this->app->singleton(FeatureInterface::class, function () {
            //     return new FeatureRepository(new Feature());
            // });

            // $this->app->singleton(InviteInterface::class, function () {
            //     return new InviteRepository(new Invite());
            // });
        }
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
