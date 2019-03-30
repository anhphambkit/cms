<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\RoleDataTable;
use Core\User\Services\Interfaces\RoleServiceInterface;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\RoleFlagRepositories;
use Core\User\Repositories\Interfaces\RoleUserRepositories;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Requests\RoleCreateRequest;
use Core\User\Requests\PostAssignRoleRequest;
use Core\User\Events\RoleUpdateEvent;
use Core\User\Events\RoleAssignmentEvent;
use AssetManager;
use AssetPipeline;

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

    /**
     * @var RoleUserRepositories
     */
    protected $roleUserRepository;

    function __construct(
        RoleServiceInterface $roleService, 
        RoleInterface $roleRepository, 
        RoleFlagRepositories $roleFlag,
        UserInterface $userRepository,
        RoleUserRepositories $roleUserRepository
    ){
        $this->roleService        = $roleService;
        $this->roleRepository     = $roleRepository;
        $this->roleFlag           = $roleFlag;
        $this->userRepository     = $userRepository;
        $this->roleUserRepository = $roleUserRepository;
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
     * @return Illuminate\View\View
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
     * @return Illuminate\View\View
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
     * @param $id
     * @param RoleCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, RoleCreateRequest $request)
    {
        $role = $this->roleRepository->findById((int)$id);
        if (!$role) return redirect()->route('admin.role.index')->with('error', __('Role not found'));
       
        $role->name        = $request->input('name');
        $role->description = $request->input('description');
        $role->updated_by  = auth()->id();
        $role->is_staff    = $request->input('is_staff', 0);
        $role->is_default  = $request->input('is_default', 0);
        $this->roleRepository->createOrUpdate($role);

        $this->roleFlag->deleteBy(['role_id' => $role->id]);

        if (!empty($request->input('flags'))) {
            $role_flags = [];
            foreach ($request->input('flags') as $flag) {
                $role_flags[] = [
                        'role_id' => $role->id,
                        'flag_id' => (int) $flag,
                    ];
            }
            $this->roleFlag->insert($role_flags);
        }

        event(new RoleUpdateEvent($role));

        return redirect()->route('admin.role.edit', $id)
            ->with('success_msg', trans('core-user::permissions.modified_success'));
    }

    /**
     * @param Request $request
     * @author TrinhLe
     */
    public function postAssignMember(PostAssignRoleRequest $request)
    {
        $user = $this->userRepository->findById($request->input('pk'));
        $role = $this->roleRepository->findById($request->input('value'));
        $this->roleUserRepository->deleteBy(['user_id' => $user->id]);

        $this->roleUserRepository->createOrUpdate([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        event(new RoleAssignmentEvent($role, $user));
    }

    /**
     * Delete a role
     *
     * @param $id
     * @return array
     * @author TrinhLe
     */
    public function getDelete($id)
    {
        $role = $this->roleRepository->findById($id);

        if (!$role) {
            abort(404);
        }

        if ($role->reference !== 'global') {
            $role->delete();
            return [
                'error' => false,
                'message' => trans('core-user::permissions.delete_success'),
            ];
        } else {
            return [
                'error' => true,
                'message' => trans('core-user::permissions.delete_global_role'),
            ];
        }
    }

    /**
     * @return array
     * @author Sang Nguyen
     */
    public function getJson()
    {
        $pl = [];
        foreach ($this->roleRepository->all() as $role) {
            $pl[] = [
                'value' => $role->id,
                'text' => $role->name,
            ];
        }

        return $pl;
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