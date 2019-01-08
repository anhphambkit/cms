<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\UserDataTable;
use AssetManager;
use AssetPipeline;

class UserController extends BaseAdminController{
    
    /**
     * Show page dashboard admin
     * @return type
     */
    public function index(UserDataTable $dataTable)
    {
        $roles = [];
        return $dataTable->render('core-user::admin.index', compact('roles'));
    }
}