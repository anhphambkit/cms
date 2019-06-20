<?php
namespace Plugins\Customer\Mails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Plugins\Customer\Models\Order;

class EmailRefundOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * [$order description]
     * @var [type]
     */
    private $order;

    /**
     * [$data description]
     * @var [type]
     */
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $data)
    {
        $this->order = $order;
        $this->data  = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        # link to order detail here
    	$link = '';
        return $this->subject( 'Request Refund Order' )
                    ->view('plugins-customer::emails.order.send_refund', compact('link'));
    }
}