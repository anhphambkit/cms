<?php

namespace Plugins\Payment\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use PayPal;

class PaymentController extends BasePublicController
{
	/**
	 * Show paypal form
	 * @author TrinhLe
	 * @param Request $request 
	 * @return Illuminate\View\View
	 */
	public function showPaypalForm(Request $request)
	{
		$provider = PayPal::setProvider('express_checkout');

		$data = [];
		$data['items'] = [
		    [
		        'name' => 'Product 1',
		        'price' => 9.99,
		        'qty' => 1
		    ],
		    [
		        'name' => 'Product 2',
		        'price' => 4.99,
		        'qty' => 1
		    ]
		];

		$data['invoice_id'] = 1;
		$data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
		$data['return_url'] = url('/payment/success');
		$data['cancel_url'] = url('/cart');

		$total = 0;
		foreach($data['items'] as $item) {
		    $total += $item['price']*$item['qty'];
		}

		$data['total'] = $total;

		//give a discount of 10% of the order amount
		$data['shipping_discount'] = round((10 / 100) * $total, 2);

		$response = $provider->setExpressCheckout($data);

		return redirect($response['paypal_link']);
	}
}