<?php
namespace Plugins\Customer\Events;

use Plugins\Customer\Models\Order;

class EventSendTrackingNumber
{
	/**
	 * [$order description]
	 * @var [type]
	 */
   	public $order;

   	/**
   	 * [__construct description]
   	 * @param Order $order [description]
   	 */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
