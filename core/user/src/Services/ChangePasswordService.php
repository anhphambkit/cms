<?php

namespace Core\User\Services;

use Core\User\Repositories\Interfaces\UserInterface;
use Core\Master\Services\ProduceServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Sentinel;

class ChangePasswordService implements ProduceServiceInterface
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
        $currentUser = acl_get_current_user();

        if (!$currentUser->isSuperUser()) {

            /**
             * @var \Hash $hash
             */
            $hash = Sentinel::getHasher();

            if (!$hash->check($request->input('old_password'), acl_get_current_user()->getUserPassword())) {
                return new Exception(trans('acl::users.current_password_not_valid'));
            }
        }

        $user = $this->userRepository->findById($request->input('id', acl_get_current_user_id()));
        Sentinel::getUserRepository()->update($user, [
            'password' => $request->input('password'),
        ]);

        do_action(USER_ACTION_AFTER_UPDATE_PASSWORD, USER_MODULE_SCREEN_NAME, $request, $user);
        return $user;
    }
}