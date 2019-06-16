<?php
namespace Plugins\Customer\Mails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Plugins\Customer\Models\Order;

class EmailConfirmOrder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * [$order description]
     * @var [type]
     */
    private $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$link = route('public.order.resend_confirmation', $this->order->id);
        return $this->subject( 'Confirmation Order' )
                    ->view('plugins-customer::emails.order.resend_confirmation', compact('link'));
    }
}