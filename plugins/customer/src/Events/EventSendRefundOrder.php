<?php
namespace Plugins\Customer\Events;

use Illuminate\Contracts\Mail\Mailer;
use Plugins\Customer\Mails\EmailRefundOrder;

class EventSendRefundOrder
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
    public function handle(SendRefundOrder $event)
    {
        $emails = ( !empty(theme_option('refund_order_mail')) )
                    ? explode(',', theme_option('refund_order_mail'))
                    : theme_option('admin_email');

        if($emails) {
            return $this->mailer
                ->to($emails)
                ->send((new EmailRefundOrder( $event->order, $event->data ))
                ->onQueue('emails'));
        }
    }
}