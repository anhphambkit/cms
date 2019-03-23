<?php

namespace Plugins\Productcategory\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Productcategory\Repositories\Interfaces\ProductcategoryRepositories;

class ProductcategoryDataTable extends DataTableAbstract
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
                return anchor_link(route('productcategory.edit', $item->id), $item->name);
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

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, PRODUCTCATEGORY_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('productcategory.edit', 'productcategory.delete', $item);
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
       $model = app(ProductcategoryRepositories::class)->getModel();
       /**
        * @var \Eloquent $model
        */
       $query = $model->select(['productcategory.id', 'productcategory.name', 'productcategory.created_at', 'productcategory.status']);
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
                'name' => 'productcategory.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'productcategory.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'productcategory.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => 'productcategory.status',
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
                'link' => route('productcategory.create'),
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
        return [
            'delete' => [
                'link' => route('productcategory.delete.many'),
                'text' => view('core-base::elements.tables.actions.delete')->render(),
            ],
            'activate' => [
                'link' => route('productcategory.change.status', ['status' => 1]),
                'text' => view('core-base::elements.tables.actions.activate')->render(),
            ],
            'deactivate' => [
                'link' => route('productcategory.change.status', ['status' => 0]),
                'text' => view('core-base::elements.tables.actions.deactivate')->render(),
            ]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author TrinhLe
     */
    protected function filename()
    {
        return PRODUCTCATEGORY_MODULE_SCREEN_NAME;
    }
}
