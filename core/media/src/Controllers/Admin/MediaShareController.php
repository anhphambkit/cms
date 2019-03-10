<?php
namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\Media\Repositories\Interfaces\MediaShareRepositories;
use Core\User\Repositories\Interfaces\UserInterface;
use BMedia;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;

class MediaShareController extends BaseAdminController
{
	/**
     * @var MediaShareInterface
     */
    protected $shareRepository;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * MediaShareController constructor.
     * @param MediaShareInterface $mediaShareRepository
     * @param UserInterface $userRepository
     * @author TrinhLe
     */
    public function __construct(MediaShareInterface $mediaShareRepository, UserInterface $userRepository)
    {
        $this->shareRepository = $mediaShareRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author TrinhLe
     */
    public function getSharedUsers(Request $request)
    {
        $share_id = $request->input('share_id');
        $share_type = $request->input('is_folder') == 'false' ? 'file' : 'folder';
        $shared_users = $this->shareRepository->getSharedUsers($share_id, $share_type)->pluck('id')->all();
        $users = $this->userRepository->getListUsers();

        foreach ($users as $user) {
            $user->is_selected = 0;
            if (in_array($user->id, $shared_users)) {
                $user->is_selected = 1;
            }
        }

        return BMedia::responseSuccess(compact('users'));
    }    
}