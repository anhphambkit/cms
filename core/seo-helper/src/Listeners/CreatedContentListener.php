<?php

namespace Core\SeoHelper\Listeners;

use Core\Base\Events\CreatedContentEvent;
use Exception;
use SeoHelper;

class CreatedContentListener
{

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     * @author TrinhLe
     */
    public function handle(CreatedContentEvent $event)
    {
        try {
            SeoHelper::saveMetaData($event->screen, $event->request, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
