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

#Feature
use Core\User\Repositories\Interfaces\FeatureRepositories;
use Core\User\Repositories\Eloquent\EloquentFeatureRepositories;
use Core\User\Repositories\Cache\CacheFeatureRepositories;

#Permission
use Core\User\Repositories\Interfaces\PermissionRepositories;
use Core\User\Repositories\Eloquent\EloquentPermissionRepositories;
use Core\User\Repositories\Cache\CachePermissionRepositories;

#RoleFlag
use Core\User\Repositories\Interfaces\RoleFlagRepositories;
use Core\User\Repositories\Eloquent\EloquentRoleFlagRepositories;
use Core\User\Repositories\Cache\CacheRoleFlagRepositories;

#RoleUser
use Core\User\Repositories\Interfaces\RoleUserRepositories;
use Core\User\Repositories\Eloquent\EloquentRoleUserRepositories;
use Core\User\Repositories\Cache\CacheRoleUserRepositories;

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
            \Core\User\Events\Listeners\AuditHandlerListener::class,
        ],
        \Core\User\Events\RoleUpdateEvent::class => [
            \Core\User\Events\Listeners\RoleUpdateListener::class,
        ],
        \Core\User\Events\RoleAssignmentEvent::class => [
            \Core\User\Events\Listeners\RoleAssignmentListener::class,
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
    protected function reigsterServices()
    {
        $this->app->singleton(
            \Core\User\Services\Interfaces\RoleServiceInterface::class,
            \Core\User\Services\Excute\RoleServiceExcute::class
        );

        $this->app->singleton(
            \Core\User\Services\Interfaces\CreateUserServiceInterface::class,
            \Core\User\Services\Excute\CreateUserServiceExcute::class
        );

        $this->app->singleton(
            \Core\User\Services\Interfaces\ChangePasswordServiceInterface::class,
            \Core\User\Services\Excute\ChangePasswordServiceExcute::class
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

            $this->app->singleton(RoleInterface::class, function () {
                return new RoleCacheDecorator(new RoleRepository(new \Core\User\Models\Role()));
            });

            $this->app->singleton(FeatureRepositories::class, function () {
                return new CacheFeatureRepositories(new EloquentFeatureRepositories(new \Core\User\Models\Feature()));
            });

            $this->app->singleton(PermissionRepositories::class, function () {
                return new CachePermissionRepositories(new EloquentPermissionRepositories(new \Core\User\Models\PermissionFlag()));
            });

            $this->app->singleton(RoleFlagRepositories::class, function () {
                return new CacheRoleFlagRepositories(new EloquentRoleFlagRepositories(new \Core\User\Models\RoleFlag()));
            });

            $this->app->singleton(RoleUserRepositories::class, function () {
                return new CacheRoleUserRepositories(new EloquentRoleUserRepositories(new \Core\User\Models\RoleUser()));
            });
            
        } else {

            $this->app->singleton(RoleInterface::class, function () {
                return new RoleRepository(new \Core\User\Models\Role());
            });

            $this->app->singleton(FeatureRepositories::class, function () {
                return new EloquentFeatureRepositories(new \Core\User\Models\Feature());
            });

            $this->app->singleton(PermissionRepositories::class, function () {
                return new EloquentPermissionRepositories(new \Core\User\Models\PermissionFlag());
            });

            $this->app->singleton(RoleFlagRepositories::class, function () {
                return new EloquentRoleFlagRepositories(new \Core\User\Models\RoleFlag());
            });

            $this->app->singleton(RoleUserRepositories::class, function () {
                return new EloquentRoleUserRepositories(new \Core\User\Models\RoleUser());
            });
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
