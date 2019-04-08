<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-08
 * Time: 23:01
 */

namespace Plugins\Product\DataTables;

use Plugins\Product\Repositories\Interfaces\BrandRepositories;
use Core\Base\DataTables\DataTableAbstract;

class BrandDataTable extends DataTableAbstract
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
                return anchor_link(route('admin.product.brand.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return table_status($item->status);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, CUSTOMER_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('admin.product.brand.edit', 'admin.product.brand.delete', $item);
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
        $model = app(BrandRepositories::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(['product_brands.id',
//            'product_brands.brand_image',
            'product_brands.name', 'product_brands.created_at', 'product_brands.status']);
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
                'name' => 'product_brands.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
//            'brand_image' => [
//                'name' => 'product.brands.brand_image',
//                'title' => trans('core-base::tables.name'),
//                'footer' => trans('core-base::tables.name'),
//                'class' => 'text-left',
//            ],
            'name' => [
                'name' => 'product_brands.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'product_brands.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => 'product_brands.status',
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
        $buttons = [
            'create' => [
                'link' => route('admin.product.brand.create'),
                'text' => view('core-base::elements.tables.actions.create')->render(),
            ],
        ];
        return $buttons;
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
        return CUSTOMER_MODULE_SCREEN_NAME;
    }
}