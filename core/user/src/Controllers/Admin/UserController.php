<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\UserDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Requests\CreateUserRequest;
use Core\User\Services\CreateUserService;
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        $roles = $this->roleRepository->pluck('name', 'id');
        return view('core-user::admin.user.create', compact('roles'));
    }

    /**
     * @param CreateUserRequest $request
     * @param CreateUserService $service
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(CreateUserRequest $request, CreateUserService $service)
    {
        // $user = $service->execute($request);

        // do_action(BASE_ACTION_AFTER_CREATE_CONTENT, USER_MODULE_SCREEN_NAME, $request, $user);

        // if ($request->input('submit') === 'save') {
        //     return redirect()->route('users.list')->with('success_msg', trans('bases::notices.create_success_message'));
        // }
        // return redirect()->route('user.profile.view', $user->id)->with('success_msg', trans('bases::notices.create_success_message'));
    }
}