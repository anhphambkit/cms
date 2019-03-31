<?php

namespace Core\User\Services;

use Core\User\Repositories\Interfaces\UserInterface;
use Core\Master\Services\CoreServiceAbstract;
use Exception;
use Illuminate\Http\Request;
use Sentinel;

class ResetPasswordService extends CoreServiceAbstract
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
        $user = $this->userRepository->getFirstBy(['username' => $request->input('user')]);
        if (!$user) {
            return new Exception(trans('core-user::auth.reset.user_not_found'));
        }

        if (Sentinel::getReminderRepository()->complete($user, $request->input('token'), $request->input('password'))) {
            Sentinel::authenticateAndRemember(['username' => $request->input('user'), 'password' => $request->input('password')]);
            return true;
        }

        return false;
    }
}