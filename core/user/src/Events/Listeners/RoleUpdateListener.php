<?php

namespace Core\User\Events\Listeners;

use Core\User\Events\RoleUpdateEvent;
use Core\User\Repositories\Interfaces\UserInterface;
use Auth;
class RoleUpdateListener
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * RoleAssignmentListener constructor.
     * @author TrinhLe
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param  RoleUpdateEvent $event
     * @return void
     * @author TrinhLe
     */
    public function handle(RoleUpdateEvent $event)
    {
        $permissions = $event->role->permissions;
        foreach ($event->role->users()->get() as $user) {
            $permissions['superuser'] = $user->super_user;
            $permissions['manage_supers'] = $user->manage_supers;

            $this->userRepository->update([
                'id' => $user->id,
            ], [
                'permissions' => json_encode($permissions),
            ]);
        }

        cache()->forget(md5('cache-dashboard-menu-' . Auth::user()->getKey()));
    }
}
