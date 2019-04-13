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
use Plugins\Blog\DataTables\CategoryDataTable;

class CategoryController extends BaseAdminController
{

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param CategoryInterface $categoryRepository
     * @author TrinhLe
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param PostTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     * @throws \Throwable
     */
    public function getList(CategoryDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-blog::categories.menu'));

        return $dataTable->renderTable(['title' => trans('plugins-blog::categories.menu')]);
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     * @author TrinhLe
     */
    public function getCreate(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins-blog::posts.create'));

        return $formBuilder->create(PostForm::class)->renderForm();
    }

    /**
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postCreate(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        /**
         * @var Post $post
         */
        $post = $this->postRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => Auth::user()->getKey(),
            'is_featured' => $request->input('is_featured', false),
        ]));

        event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.list'))
            ->setNextUrl(route('posts.edit', $post->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     * @author TrinhLe
     */
    public function getEdit($id, FormBuilder $formBuilder, Request $request)
    {
        $post = $this->postRepository->findOrFail($id);

        event(new BeforeEditContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        page_title()->setTitle(trans('plugins-blog::posts.edit') . ' #' . $id);

        return $formBuilder->create(PostForm::class, ['model' => $post])->renderForm();
    }

    /**
     * @param int $id
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function postEdit(
        $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $post = $this->postRepository->findOrFail($id);

        $post->fill($request->input());
        $post->is_featured = $request->input('is_featured', false);

        $this->postRepository->createOrUpdate($post);

        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.list'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $post = $this->postRepository->findOrFail($id);
            $this->postRepository->delete($post);

            event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

            return $response
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.cannot_delete'));
        }
    }
}
