<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\UserDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Requests\CreateUserRequest;
use Core\User\Services\CreateUserService;
use AssetManager;
use AssetPipeline;

class UserController extends BaseAdminController{
    
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * UserController constructor.
     * @param RoleInterface $roleRepository
     */
    public function __construct( RoleInterface $roleRepository, UserInterface $userRepository ) 
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
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
        $user = $service->execute($request);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.user.index')->with('success_msg', trans('core-base::notices.create_success_message'));
        }
        return redirect()->route('admin.user.profile', $user->id)->with('success_msg', trans('core-base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View| \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen
     */
    public function getUserProfile($id)
    {
        page_title()->setTitle('User profile # ' . $id);
        
        AssetManager::addAsset('cropper-js', '//cdnjs.cloudflare.com/ajax/libs/cropper/0.7.9/cropper.min.js');
        AssetManager::addAsset('bootstrap-pwstrength-js', 'backend/core/user/packages/pwstrength-bootstrap/pwstrength-bootstrap.min.js');
        AssetManager::addAsset('profile-js', 'backend/core/user/assets/js/profile.js');
        AssetPipeline::requireJs('cropper-js');
        AssetPipeline::requireJs('bootstrap-pwstrength-js');
        AssetPipeline::requireJs('profile-js');

        try {
            $user = $this->userRepository->findById($id);
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error_msg', trans('core-user::users.not_found'));
        }

        return view('core-user::admin.user.profile')
            ->with('user', $user);
    }

    /**
     * @param $id
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen
     */
    public function postUpdateProfile($id, UpdateProfileRequest $request)
    {
        $user = $this->userRepository->findById($id);

        /**
         * @var User $currentUser
         */
        $currentUser = acl_get_current_user();
        if (($currentUser->hasPermission('users.update-profile') && $currentUser->getUserId() === $user->id) || $currentUser->isSuperUser()) {
            if ($user->email !== $request->input('email')) {
                $users = $this->userRepository->count(['email' => $request->input('email')]);
                if (!$users) {
                    $user->email = $request->input('email');
                } else {
                    return redirect()->route('user.profile.view', [$id])
                        ->with('error_msg', trans('acl::users.email.exist'))
                        ->withInput();
                }
            }

            if ($user->username !== $request->input('username')) {
                $users = $this->userRepository->count(['username' => $request->input('username')]);
                if (!$users) {
                    $user->username = $request->input('username');
                } else {
                    return redirect()->route('user.profile.view', [$id])
                        ->with('error_msg', trans('acl::users.username_exist'))
                        ->withInput();
                }
            }
        }

        $user->fill($request->input());
        $user->completed_profile = 1;
        $this->userRepository->createOrUpdate($user);
        do_action(USER_ACTION_AFTER_UPDATE_PROFILE, USER_MODULE_SCREEN_NAME, $request, $user);

        return redirect()->route('user.profile.view', [$id])
            ->with('success_msg', trans('acl::users.update_profile_success'));
    }
}