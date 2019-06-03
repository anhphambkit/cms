<?php
namespace Plugins\Product\Requests;

use Core\Master\Requests\CoreRequest;
use Plugins\Customer\Models\Order;
class RefundRequest extends CoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author TrinhLe
     */
    public function rules()
    {
    	$max = $this->getMaxAmountRefund();
        return [
            'amount' => "required|numeric|min:0|max:{$max}",
        ];
    }

    /**
     * [getMaxAmountRefund description]
     * @return [type] [description]
     */
    protected function getMaxAmountRefund()
    {
        $invoice = Order::find($this->route()->parameter('id'));
        return (float)$invoice->total_amount_order - (float)$invoice->amount_refund;
    }
}