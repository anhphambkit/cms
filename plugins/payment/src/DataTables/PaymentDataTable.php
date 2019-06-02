<?php

namespace Plugins\Payment\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Payment\Repositories\Interfaces\PaymentRepositories;

class PaymentDataTable extends DataTableAbstract
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('paypal_id', function ($item) {
                return anchor_link(route('admin.payment.edit', $item->id), $item->paypal_id);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return ucfirst($item->status);
            })
            ->editColumn('amount', function ($item) {
                return  $item->amount;
            })
            ->editColumn('payment_method', function ($item) {
                return ucfirst($item->payment_method);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, PAYMENT_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('admin.payment.edit', 'admin.payment.delete', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author TrinhLe
     */
    public function query()
    {
       $model = app(PaymentRepositories::class)->getModel();
       /**
        * @var \Eloquent $model
        */
       $query = $model->select([
            'payment_transactions.id',
            'payment_transactions.paypal_id',
            'payment_transactions.created_at',
            'payment_transactions.status',
            'payment_transactions.payment_method',
            'payment_transactions.amount'
        ]);
       return $query;
    }

    /**
     * @return array
     * @author TrinhLe
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name'   => 'payment_transactions.id',
                'title'  => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width'  => '20px',
                'class'  => 'searchable searchable_id',
            ],
            'paypal_id' => [
                'name'   => 'payment_transactions.paypal_id',
                'title'  => __('Paypal ID'),
                'footer' => __('Paypal ID'),
                'class'  => 'text-left searchable',
            ],
            'payment_method' => [
                'name'   => 'payment_transactions.payment_method',
                'title'  => __('Payment method'),
                'footer' => __('Payment method'),
                'class'  => 'text-left',
            ],
            'amount' => [
                'name'   => 'payment_transactions.amount',
                'title'  => __('Amount'),
                'footer' => __('Amount'),
                'class'  => 'text-left',
            ],
            'created_at' => [
                'name'   => 'payment_transactions.created_at',
                'title'  => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width'  => '100px',
                'class'  => 'searchable',
            ],
            'status' => [
                'name' => 'payment_transactions.status',
                'title' => trans('core-base::tables.status'),
                'footer' => trans('core-base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function buttons()
    {
        return [];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function actions()
    {
        return [];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author TrinhLe
     */
    protected function filename()
    {
        return PAYMENT_MODULE_SCREEN_NAME;
    }
}
