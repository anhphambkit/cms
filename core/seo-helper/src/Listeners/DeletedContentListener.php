<?php

namespace Core\SeoHelper\Listeners;

use Core\Base\Events\DeletedContentEvent;
use Exception;
use SeoHelper;

class DeletedContentListener
{

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     * @author TrinhLe
     */
    public function handle(DeletedContentEvent $event)
    {
        try {
            SeoHelper::deleteMetaData($event->screen, $event->data);
        } catch (Exception $exception) {
            info($exception->getMessage());
        }
    }
}
