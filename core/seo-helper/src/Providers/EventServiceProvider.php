<?php

namespace Core\SeoHelper\Providers;

use Core\Base\Events\CreatedContentEvent;
use Core\Base\Events\DeletedContentEvent;
use Core\Base\Events\UpdatedContentEvent;
use Core\SeoHelper\Listeners\CreatedContentListener;
use Core\SeoHelper\Listeners\DeletedContentListener;
use Core\SeoHelper\Listeners\UpdatedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     * @author TrinhLe
     */
    protected $listen = [
        UpdatedContentEvent::class => [
            UpdatedContentListener::class,
        ],
        CreatedContentEvent::class => [
            CreatedContentListener::class,
        ],
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
    ];
}
