<?php
namespace Plugins\Customer\Events;

use Plugins\Customer\Models\Order;

class EventSendOrderProduct
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
     * [$emailType description]
     * @var [type]
     */
    public $emailType;

   	/**
   	 * [__construct description]
   	 * @param Order $order [description]
   	 */
    public function __construct(Order $order, string $emailType, array $data = [])
    {
        $this->order     = $order;
        $this->data      = $data;
        $this->emailType = $emailType;
    }
}
