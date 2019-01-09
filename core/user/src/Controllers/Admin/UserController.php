<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\UserDataTable;
use AssetManager;
use AssetPipeline;

class UserController extends BaseAdminController{
    
    /**
     * Show page dashboard user
     * @author TrinhLe
     * @return View
     */
    public function index(UserDataTable $dataTable)
    {
        $roles = [];
        return $dataTable->render('core-user::admin.user.index', compact('roles'));
    }
}