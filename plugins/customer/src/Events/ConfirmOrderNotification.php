<?php
namespace Plugins\Customer\Events;

use Illuminate\Contracts\Mail\Mailer;
use Plugins\Customer\Mails\EmailConfirmOrder;

class ConfirmOrderNotification
{
    /*
      * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /** 
     * [handle description]
     * @param  ArcEmployeeCreated $event [description]
     * @return [type]                    [description]
     */
    public function handle(EventConfirmOrder $event)
    {
        $order = $event->order;
        $email = show_email_invoice($order);

        return $this->mailer
            ->to($email)
            ->send((new EmailConfirmOrder( $order ))
            ->onQueue('emails'));
    }
}