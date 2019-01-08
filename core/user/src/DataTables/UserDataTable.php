<?php

namespace Core\User\DataTables;

use Core\User\Repositories\Interfaces\UserInterface;
use Core\Base\DataTables\DataTableAbstract;

class UserDataTable extends DataTableAbstract
{

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Sang Nguyen
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('checkbox', function ($item) {
                return $item->id;
            })
            ->editColumn('username', function ($item) {
                return $item->username;
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('role_name', function ($item) {
                return view('core-user::users.partials.role', compact('item'))->render();
            })
            ->editColumn('status', function ($item) {
                return table_status(acl_is_user_activated($item) ? 1 : 0);
            })
            ->addColumn('operations', function ($item) {
                return view('core-user::users.partials.actions', compact('item'))->render();
            })
            ->removeColumn('role_id')
            ->escapeColumns([])
            ->make(true);
        
        return $data;
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author Sang Nguyen
     * @since 2.1
     */
    public function query()
    {
        $model = app(UserInterface::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model
            ->select([
                'users.id',
                'users.username',
                'users.email',
                'roles.name as role_name',
                'roles.id as role_id',
                'users.updated_at',
                'users.created_at',
            ])
            ->leftJoin('role_users', 'users.id', '=', 'role_users.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'role_users.role_id');
        return $query;
    }

    /**
     * @return array
     * @author Sang Nguyen
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'users.id',
                'title' => __('ID'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'username' => [
                'name' => 'users.username',
                'title' => __('Username'),
                'class' => 'text-left searchable',
            ],
            'email' => [
                'name' => 'users.email',
                'title' => __('Email'),
                'class' => 'searchable',
            ],
            'role_name' => [
                'name' => 'roles.name',
                'title' => __('Role'),
            ],
            'created_at' => [
                'name'  => 'users.created_at',
                'title' => __('CreatedAt'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name'       => 'users.status',
                'title'      => __('Status'),
                'width'      => '100px',
                'orderable'  => false,
                'searchable' => false,
                'exportable' => false,
                'printable'  => false,
            ],
        ];
    }

    /**
     * @return array
     * @author Sang Nguyen
     * @since 2.1
     */
    public function buttons()
    {
        return [];
    }

    /**
     * @return array
     * @author Sang Nguyen
     * @since 2.1
     */
    public function actions()
    {
        return [];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author Sang Nguyen
     * @since 2.1
     */
    protected function filename()
    {
        return USER_MODULE_SCREEN_NAME;
    }
}
