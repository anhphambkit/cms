<?php
namespace Plugins\Customer\Mails;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Plugins\Customer\Models\Order;

class EmailReplaceProductOrder extends Mailable implements ShouldQueue
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
     * [$tries description]
     * @var integer
     */
    public $tries = 3;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, array $data = [])
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
        return $this->subject( 'Request Replace Order' )
                    ->view('plugins-customer::emails.order.send_replace', compact('link'));
    }
}