<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\RoleDataTable;
use AssetManager;
use AssetPipeline;
use Core\User\Services\Interfaces\RoleServiceInterface;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\RoleFlagRepositories;
use Core\User\Requests\RoleCreateRequest;

class RoleController extends BaseAdminController
{
    
    /**
     * @var RoleServiceInterface
     */
    protected $roleService;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var RoleFlagRepositories
     */
    protected $roleFlag;

    function __construct(RoleServiceInterface $roleService, RoleInterface $roleRepository, RoleFlagRepositories $roleFlag)
    {
        $this->roleService    = $roleService;
        $this->roleRepository = $roleRepository;
        $this->roleFlag       = $roleFlag;
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
        $this->addAssets();

        list( $flags, $children ) = $this->roleService->getFlagsPermission();

        $active = [];

        return view('core-user::admin.role.create',compact('flags', 'children', 'active'));
    }

    /**
     * Show page dashboard role
     * @author TrinhLe
     * @return View
     */
    public function postCreate(RoleCreateRequest $request)
    {
        $role = $this->roleRepository->create([
            'name'        => $request->input('name'),
            'slug'        => str_slug($request->input('name')),
            'description' => $request->input('description'),
            'is_staff'    => $request->input('is_staff') !== null ? 1 : 0,
            'is_default'  => $request->input('is_default') !== null ? 1 : 0,
            'created_by'  => auth()->id(),
            'updated_by'  => auth()->id(),
        ]);

        $this->roleFlag->deleteBy(['role_id' => $role->id]);

        if (!empty($request->input('flags'))) {
            foreach ($request->input('flags') as $flag) {
                $this->roleFlag->firstOrCreate(['role_id' => $role->id, 'flag_id' => $flag]);
            }
        }

        return redirect()->route('admin.role.index')
            ->with('success_msg', trans('core-user::permissions.create_success'));
    }

    /**
     * Show layout edit role
     * @author  TrinhLe
     * @param type $id 
     * @return Illuminate\View\View
     */
    public function getEdit($id)
    {
        $role = $this->roleRepository->findById((int)$id);
        if (!$role) return redirect()->back()->with('error', __('Role not found'));

        $this->addAssets();

        list( $flags, $children ) = $this->roleService->getFlagsPermission();

        return view('core-user::admin.role.edit')
            ->with('role', $role)
            ->with('active', $role->flags()->pluck('flag')->all())
            ->with('children', $children)
            ->with('flags', $flags);
    }

    /**
     * Add frontend plugins for layout
     * @author TrinhLe
     */
    private function addAssets()
    {
        AssetManager::addAsset('role-js', 'backend/core/user/assets/js/role.js');
        AssetPipeline::requireCss('jquery-tree-css');
        AssetPipeline::requireJs('jquery-tree-js');
        AssetPipeline::requireJs('role-js');
    }
}