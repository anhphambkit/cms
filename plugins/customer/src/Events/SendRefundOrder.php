<?php
namespace Plugins\Customer\Events;

use Plugins\Customer\Models\Order;

class SendRefundOrder
{
	/**
	 * [$order description]
	 * @var [type]
	 */
   	public $order;

    /**
     * [$order description]
     * @var [type]
     */
    public $data;

   	/**
   	 * [__construct description]
   	 * @param Order $order [description]
   	 */
    public function __construct(Order $order, $data)
    {
        $this->order = $order;
        $this->data  = $data;
    }
}
