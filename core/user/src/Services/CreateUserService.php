<?php

namespace Core\User\Services;

use Core\User\Events\RoleAssignmentEvent;
use Core\User\Models\User;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\RoleUserRepositories;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\Master\Services\CoreServiceAbstract;
use Illuminate\Http\Request;
use Sentinel;

class CreateUserService extends CoreServiceAbstract
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * @var RoleUserRepositories
     */
    protected $roleUserRepository;

    /**
     * CreateUserService constructor.
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     * @param RoleUserRepositories $roleUserRepository
     */
    public function __construct(UserInterface $userRepository, RoleInterface $roleRepository, RoleUserRepositories $roleUserRepository)
    {
        $this->userRepository     = $userRepository;
        $this->roleRepository     = $roleRepository;
        $this->roleUserRepository = $roleUserRepository;
    }

    /**
     * @param Request $request
     * @author TrinhLe
     * @return User|false|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function execute(Request $request)
    {
        $user = $this->userRepository->createOrUpdate(array_merge($request->input(), [
            'profile_image' => config('acl.avatar.default'),
        ]));

        if ($request->has('username') && $request->has('password')) {
            $credentials = [
                'username' => $request->input('username'),
                'password' => $request->input('password'),
            ];
            if (Sentinel::getUserRepository()->validForCreation($credentials)) {

                /**
                 * @var User $user
                 */
                $user = Sentinel::getUserRepository()->update($user, $credentials);

                if (acl_activate_user($user) && $request->has('role_id')) {

                    $role = $this->roleRepository->getFirstBy([
                        'id' => $request->input('role_id'),
                    ]);

                    if (!empty($role)) {
                        $this->roleUserRepository->firstOrCreate([
                            'user_id' => $user->id,
                            'role_id' => $request->input('role_id'),
                        ]);

                        event(new RoleAssignmentEvent($role, $user));
                    }
                }
            }
        }

        return $user;
    }
}
