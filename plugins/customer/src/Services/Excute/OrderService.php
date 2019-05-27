<?php

namespace Plugins\Customer\Services\Excute;
use Plugins\Customer\Services\IOrderService;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;

class OrderService implements IOrderService
{
	/**
	 * [$orderRepository description]
	 * @var OrderRepositories
	 */
	private $orderRepository;

	public function __construct(OrderRepositories $orderRepository)
	{
		$this->orderRepository = $orderRepository;
	}

    /**
     * [createOrderCustomerProduct description]
     * @param  sessionCart
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrderCustomerProduct(array $sessionCheckout, int $paymentMethod){}
}