<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\UserDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use AssetManager;
use AssetPipeline;

class UserController extends BaseAdminController{
    
    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * UserController constructor.
     * @param RoleInterface $roleRepository
     */
    public function __construct( RoleInterface $roleRepository ) 
    {
        $this->roleRepository = $roleRepository;
        parent::__construct();
    }

    /**
     * Show page dashboard user
     * @author TrinhLe
     * @return View
     */
    public function index(UserDataTable $dataTable)
    {
        AssetPipeline::requireCss('editable-css');
        AssetPipeline::requireJs('editable-js');

        $roles = $this->roleRepository->pluck('name', 'id');
        return $dataTable->render('core-user::admin.user.index', compact('roles'));
    }
}