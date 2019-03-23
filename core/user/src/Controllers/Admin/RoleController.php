<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\RoleDataTable;
use AssetManager;
use AssetPipeline;
use Core\User\Services\Interfaces\RoleServiceInterface;

class RoleController extends BaseAdminController
{
    
    /**
     * @var RoleServiceInterface
     */
    protected $roleService;

    function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function index(RoleDataTable $dataTable)
    {
        $roles = [];
        return $dataTable->render('core-user::admin.role.index', compact('roles'));
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function getCreate()
    {
        AssetManager::addAsset('role-js', 'backend/core/user/assets/js/role.js');
        AssetPipeline::requireCss('jquery-tree-css');
        AssetPipeline::requireJs('jquery-tree-js');
        AssetPipeline::requireJs('role-js');

        list( $flags, $children ) = $this->roleService->getFlagsPermission();

        $active = [];

        return view('core-user::admin.role.create',compact('flags', 'children', 'active'));
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function postCreate(RoleDataTable $dataTable)
    {
        $roles = [];
        return $dataTable->render('core-user::admin.role.index', compact('roles'));
    }
}