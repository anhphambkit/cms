<?php

namespace Plugins\Customer\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;

class OrderDataTable extends DataTableAbstract
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
            ->editColumn('name', function ($item) {
                return anchor_link(route('admin.order.edit', $item->id), $item->name);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return ucfirst(find_reference_by_id($item->status)->value);
            })
            ->editColumn('total_amount_order', function ($item) {
                return  $item->total_amount_order;
            })
            ->editColumn('amount_refund', function ($item) {
                return  $item->amount_refund;
            })
            ->editColumn('payment_method', function ($item) {
                return ucfirst($item->payment_method);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, ORDER_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                // return table_actions('admin.order.edit', 'admin.order.delete', $item);
                return view('plugins-customer::order.refund', compact('item'))->render();
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
       $model = app(OrderRepositories::class)->getModel();
       /**
        * @var \Eloquent $model
        */
       $query = $model->select([
            'customer_orders.id',
            'customer_orders.paypal_id',
            'customer_orders.payment_method',
            'customer_orders.created_at',
            'customer_orders.status',
            'customer_orders.total_amount_order',
            'customer_orders.amount_refund',
            'customer_orders.address_billing'
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
                'name' => 'customer_orders.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'paypal_id' => [
                'name'   => 'customer_orders.paypal_id',
                'title'  => __('Paypal ID'),
                'footer' => __('Paypal ID'),
                'class'  => 'text-left searchable',
            ],
            'payment_method' => [
                'name'   => 'customer_orders.payment_method',
                'title'  => __('Payment method'),
                'footer' => __('Payment method'),
                'class'  => 'text-left',
            ],
            'total_amount_order' => [
                'name'   => 'customer_orders.total_amount_order',
                'title'  => __('Amount'),
                'footer' => __('Amount'),
                'class'  => 'text-left',
            ],
            'amount_refund' => [
                'name'   => 'customer_orders.amount_refund',
                'title'  => __('Amount refund'),
                'footer' => __('Amount refund'),
                'class'  => 'text-left',
            ],
            'status' => [
                'name' => 'customer_orders.status',
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
        return ORDER_MODULE_SCREEN_NAME;
    }
}
