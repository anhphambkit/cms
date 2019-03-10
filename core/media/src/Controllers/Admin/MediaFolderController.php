<?php
namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
#Interface Media
use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use BMedia;
use Illuminate\Http\JsonResponse;
use Exception;
use Core\Media\Requests\MediaFolderRequest;

class MediaFolderController extends BaseAdminController
{
    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * FolderController constructor.
     * @param MediaFolderInterface $folderRepository
     * @param MediaFileInterface $fileRepository
     * @author TrinhLe
     */
    public function __construct(MediaFolderInterface $folderRepository, MediaFileInterface $fileRepository)
    {
        $this->folderRepository = $folderRepository;
        $this->fileRepository = $fileRepository;
        parent::__construct();
    }

    /**
     * @param MediaFolderRequest $request
     * @return JsonResponse
     * @author TrinhLe
     */
    public function postCreate(MediaFolderRequest $request)
    {
        $name = $request->input('name');

        if (in_array($name, config('media.upload.reserved_names', []))) {
            return BMedia::responseError(trans('media::media.name_reserved'));
        }

        try {
            $parent_id = $request->input('parent_id');

            $folder = $this->folderRepository->getModel();
            $folder->user_id = rv_media_get_current_user_id();
            $folder->name = $this->folderRepository->createName($name, $parent_id);
            $folder->slug = $this->folderRepository->createSlug($name, $parent_id);
            $folder->parent_id = $parent_id;
            $this->folderRepository->createOrUpdate($folder);
            return BMedia::responseSuccess([], trans('media::media.folder_created'));
        } catch (Exception $ex) {
            return BMedia::responseError($ex->getMessage());
        }
    }
   
}