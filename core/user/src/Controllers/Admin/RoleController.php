<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\RoleDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Requests\RoleCreateRequest;
use Core\User\Requests\PostAssignRoleRequest;
use Core\User\Events\RoleUpdateEvent;
use Core\User\Events\RoleAssignmentEvent;
use AssetManager;
use AssetPipeline;
use Core\User\Traits\RoleTrait;
use Illuminate\Support\Str;
use Auth;

class RoleController extends BaseAdminController
{
    use RoleTrait;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    function __construct(
        RoleInterface $roleRepository, 
        UserInterface $userRepository
    ){
        $this->roleRepository     = $roleRepository;
        $this->userRepository     = $userRepository;
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

        list( $flags, $children ) = $this->getFlagsPermission();

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
        $role = $this->roleRepository->createOrUpdate([
            'name'        => $request->input('name'),
            'slug'        => Str::slug($request->input('name')),
            'permissions' => $this->cleanPermission($request->input('flags')),
            'description' => $request->input('description'),
            'is_default'  => $request->input('is_default') !== null ? 1 : 0,
            'created_by'  => Auth::user()->getKey(),
            'updated_by'  => Auth::user()->getKey(),
        ]);

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

        list( $flags, $children ) = $this->getFlagsPermission();

        return view('core-user::admin.role.edit')
            ->with('role', $role)
            ->with('active', $role->permissions)
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
        $role->permissions = $this->cleanPermission($request->input('flags'));
        $role->description = $request->input('description');
        $role->updated_by  = Auth::user()->getKey();
        $role->is_default  = $request->input('is_default', 0);
        $this->roleRepository->createOrUpdate($role);

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
        $user = $this->userRepository->findOrFail($request->input('pk'));
        $role = $this->roleRepository->findOrFail($request->input('value'));

        $user->roles()->sync([$role->id]);

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
     * Return a correctly type casted permissions array
     * @param array $permissions
     * @return array
     * @author TrinhLe
     */
    protected function cleanPermission($permissions)
    {
        if (!$permissions) {
            return [];
        }
        $cleanedPermissions = [];
        foreach ($permissions as $permissionName) {
            $cleanedPermissions[$permissionName] = true;
        }

        return $cleanedPermissions;
    }

    /**
     * Add frontend plugins for layout
     * @author TrinhLe
     */
    protected function addAssets()
    {
        AssetManager::addAsset('role-js', 'backend/core/user/assets/js/role.js');
        AssetPipeline::requireCss('jquery-tree-css');
        AssetPipeline::requireJs('jquery-tree-js');
        AssetPipeline::requireJs('role-js');
    }
}