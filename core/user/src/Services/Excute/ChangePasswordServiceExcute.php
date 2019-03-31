<?php 
namespace Core\User\Services\Excute;
use Core\User\Services\Interfaces\ChangePasswordServiceInterface;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Repositories\Interfaces\UserInterface;
use Exception;
use Illuminate\Http\Request;
use Sentinel;

class ChangePasswordServiceExcute extends CoreServiceAbstract implements ChangePasswordServiceInterface
{
	/**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * ResetPasswordService constructor.
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return bool|\Exception
     * @author TrinhLe
     */
    public function execute(Request $request)
    {
        $currentUser = auth()->user();

        if (!$currentUser->isSuperUser()) {

            /**
             * @var \Hash $hash
             */
            $hash = Sentinel::getHasher();

            if (!$hash->check($request->input('old_password'), $currentUser->getUserPassword())) {
                return new Exception(trans('core-user::users.current_password_not_valid'));
            }
        }

        $user = $this->userRepository->findById($request->input('id', auth()->id()));
        Sentinel::getUserRepository()->update($user, [
            'password' => $request->input('password'),
        ]);

        do_action(USER_ACTION_AFTER_UPDATE_PASSWORD, USER_MODULE_SCREEN_NAME, $request, $user);
        return $user;
    }
}