<?php

namespace Plugins\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Plugins\Customer\Middlewares\RedirectIfNotCustomer;
use Plugins\Customer\Middlewares\RedirectIfCustomer;
use Plugins\Customer\Models\Customer;
use Illuminate\View\View;
use Plugins\Customer\Repositories\Interfaces\ProductsInOrderRepositories;
use Plugins\Customer\Services\Excute\ProductsInOrderServices;
use Plugins\Customer\Services\IOrderService;
use Plugins\Customer\Services\Excute\OrderService;
use Plugins\Customer\Services\IProductsInOrderServices;
use Illuminate\Support\Facades\Event;
use Plugins\Customer\Events\ConfirmOrderNotification;
use Plugins\Customer\Events\EventConfirmOrder;
use Plugins\Customer\Events\EventSendRefundOrder;
use Plugins\Customer\Events\SendRefundOrder;
use Plugins\Customer\Events\EventSendOrderProduct;
use Plugins\Customer\Events\SendOrderProduct;
use Plugins\Customer\Events\EventSendTrackingNumber;
use Plugins\Customer\Events\SendTrackingNumber;
class CustomerServiceProvider extends ServiceProvider
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
        config([
            'auth.guards.customer'     => [
                'driver'   => 'session',
                'provider' => 'customers',
            ],
            'auth.providers.customers' => [
                'driver' => 'eloquent',
                'model'  => Customer::class,
            ],
            'auth.passwords.customers' => [
                'provider' => 'customers',
                'table'    => 'customers_password_resets',
                'expire'   => 60,
            ],
            'auth.guards.member-api' => [
                'driver'   => 'passport',
                'provider' => 'customers',
            ],
        ]);

        /**
         * @var Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('customer', RedirectIfNotCustomer::class);
        $router->aliasMiddleware('customer.guest', RedirectIfCustomer::class);

        register_repositories($this);
        $this->app->singleton(IOrderService::class, OrderService::class);
        $this->app->singleton(IProductsInOrderServices::class, ProductsInOrderServices::class);

        Event::listen(EventConfirmOrder::class, ConfirmOrderNotification::class);
        Event::listen(EventSendRefundOrder::class, SendRefundOrder::class);
        Event::listen(EventSendOrderProduct::class, SendOrderProduct::class);
        Event::listen(EventSendTrackingNumber::class, SendTrackingNumber::class);
    }

    /**
     * Get config repositories
     * @author TrinhLe
     * @return [array] [description]
     */
    public function getRespositories():array
    {
        return [
            CustomerRepositories::class => \Plugins\Customer\Models\Customer::class,
            OrderRepositories::class    => \Plugins\Customer\Models\Order::class,
            ProductsInOrderRepositories::class    => \Plugins\Customer\Models\ProductsInOrder::class,
        ];
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        view()->composer('*', \Plugins\Customer\Composers\CurrentCustomerComposer::class);
    }
}
