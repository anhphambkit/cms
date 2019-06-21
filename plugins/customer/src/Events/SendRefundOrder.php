<?php
namespace Plugins\Customer\Events;

use Illuminate\Contracts\Mail\Mailer;
use Plugins\Customer\Mails\EmailRefundOrder;

class SendRefundOrder
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
    public function handle(EventSendRefundOrder $event)
    {
        $emails = get_emails_option('refund_order_mail');
        if($emails) {
            return $this->mailer
                ->to($emails)
                ->send((new EmailRefundOrder( $event->order, $event->data ))
                ->onQueue('emails'));
        }
    }
}