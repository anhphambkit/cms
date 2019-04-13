<?php

namespace Plugins\Blog\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Blog\Models\Post;
use Plugins\Blog\Repositories\Interfaces\PostRepositories as PostInterface;
use Plugins\Blog\Repositories\Interfaces\CategoryRepositories as CategoryInterface;
use Plugins\Blog\Repositories\Interfaces\TagRepositories as TagInterface;
use Plugins\Blog\Services\StoreCategoryService;
use Plugins\Blog\Services\StoreTagService;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Core\Base\Events\CreatedContentEvent;
use Core\Base\Events\DeletedContentEvent;
use Core\Base\Events\UpdatedContentEvent;
use Plugins\Blog\DataTables\TagDataTable;

class TagController extends BaseAdminController
{

    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @param TagInterface $tagRepository
     */
    public function __construct(TagInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param PostTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     * @throws \Throwable
     */
    public function getList(TagDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-blog::tags.menu_name'));

        return $dataTable->renderTable(['title' => trans('plugins-blog::tags.models')]);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-blog::tags.create'));

        return view('plugins-blog::tag.create');
    }

    /**
     * @param TagRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postCreate(TagRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->tagRepository->createOrUpdate(array_merge($request->input(),
            ['author_id' => Auth::user()->getKey()]));
        event(new CreatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('tags.list'))
            ->setNextUrl(route('tags.edit', $tag->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     * @author TrinhLe
     */
    public function getEdit($id, Request $request, FormBuilder $formBuilder)
    {
        $tag = $this->tagRepository->findOrFail($id);

        event(new BeforeEditContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

        page_title()->setTitle(trans('plugins/blog::tags.edit') . ' #' . $id);

        return $formBuilder->create(TagForm::class, ['model' => $tag])->renderForm();
    }

    /**
     * @param int $id
     * @param TagRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postEdit($id, TagRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->tagRepository->findOrFail($id);
        $tag->fill($request->input());

        $this->tagRepository->createOrUpdate($tag);
        event(new UpdatedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('tags.list'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $tag = $this->tagRepository->findOrFail($id);
            $this->tagRepository->delete($tag);

            event(new DeletedContentEvent(TAG_MODULE_SCREEN_NAME, $request, $tag));

            return $response->setMessage(trans('plugins/blog::tags.deleted'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/blog::tags.cannot_delete'));
        }
    }
}
