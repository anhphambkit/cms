<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\SuperUserDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Services\Interfaces\RoleServiceInterface;
use AssetManager;
use AssetPipeline;
use Illuminate\Http\Request;

class SuperUserController extends BaseAdminController{
    
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var RoleServiceInterface
     */
    protected $roleService;

    /**
     * UserController constructor.
     * @param RoleInterface $roleRepository
     */
    public function __construct( RoleServiceInterface $roleService, RoleInterface $roleRepository, UserInterface $userRepository ) 
    {
        $this->roleService    = $roleService;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /**
     * Show page dashboard user
     * @author TrinhLe
     * @return View
     */
    public function index(SuperUserDataTable $dataTable)
    {
        $roles = $this->roleRepository->pluck('name', 'id');
        return $dataTable->render('core-user::admin.user.super-index', compact('roles'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(Request $request)
    {
        try {
            $user = $this->userRepository->getFirstBy(['email' => $request->input('email')]);
            if (!empty($user)) {
                $user->updatePermission('superuser', true);
                $user->super_user = 1;
                $this->userRepository->createOrUpdate($user);
                return redirect()->route('users-supers.list')->with('success_msg', trans('bases::system.supper_granted'));
            }
            return redirect()->route('users-supers.list')->with('error_msg', trans('bases::system.cant_find_user_with_email'))->withInput();
        } catch (Exception $e) {
            return redirect()->route('users-supers.list')->with('error_msg', trans('bases::system.cant_find_user_with_email'))->withInput();
        }

    }
}