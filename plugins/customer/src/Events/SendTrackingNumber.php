<?php
namespace Plugins\Customer\Events;

use Illuminate\Contracts\Mail\Mailer;
use Plugins\Customer\Mails\EmailTrackingNumberOrder;

class SendTrackingNumber
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
    public function handle(EventSendTrackingNumber $event)
    {
        $order = $event->order;
        $email = show_email_invoice($order);

        return $this->mailer
            ->to($email)
            ->send((new EmailTrackingNumberOrder( $order ))
            ->onQueue('emails'));
    }
}