<?php
namespace Plugins\Customer\Events;

use Illuminate\Contracts\Mail\Mailer;
use Plugins\Customer\Mails\EmailCancelProductOrder;
use Plugins\Customer\Mails\EmailReplaceProductOrder;
use Plugins\Customer\Mails\EmailReturnProductOrder;

class SendOrderProduct
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
    public function handle(EventSendOrderProduct $event)
    {
        $emails       = get_emails_option('order_emails');
        $mailSelector = false;
        switch ($event->emailType) {
            case EMAIL_RETURN_PRODUCT_ORDER:
                # code...
                $mailSelector = (new EmailReturnProductOrder( $event->order, $event->data ))->onQueue('emails');
                break;
            case EMAIL_REPLACE_PRODUCT_ORDER:
                # code...
                $mailSelector = (new EmailReplaceProductOrder( $event->order, $event->data ))->onQueue('emails');
                break;
            case EMAIL_CANCEL_PRODUCT_ORDER:
                # code...
                $mailSelector = (new EmailCancelProductOrder( $event->order, $event->data ))->onQueue('emails');
                break;
            default:
                # code...
                break;
        }

        if($emails && $mailSelector) {
            return $this->mailer
                ->to($emails)
                ->send($mailSelector);
        }
    }
}