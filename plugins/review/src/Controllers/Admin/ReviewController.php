<?php

namespace Plugins\Review\Controllers\Admin;

use Illuminate\Http\Request;
use Plugins\Review\Requests\ReviewRequest;
use Plugins\Review\Repositories\Interfaces\ReviewRepositories;
use Plugins\Review\DataTables\ReviewDataTable;
use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Base\Responses\BaseHttpResponse;
use Plugins\Review\Repositories\Interfaces\ReviewCommentRepositories;
use Plugins\Review\Requests\PostReviewRequest;

class ReviewController extends BaseAdminController
{
    /**
     * @var ReviewRepositories
     */
    protected $reviewRepository;

    /**
     * @var ReviewRepositories
     */
    protected $reviewCommentRepository;

    /**
     * ReviewController constructor.
     * @param ReviewRepositories $reviewRepository
     * @author TrinhLe
     */
    public function __construct(ReviewRepositories $reviewRepository, ReviewCommentRepositories $reviewCommentRepository)
    {
        $this->reviewRepository        = $reviewRepository;
        $this->reviewCommentRepository = $reviewCommentRepository;
    }

    /**
     * Display all review
     * @param ReviewDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getList(ReviewDataTable $dataTable)
    {

        page_title()->setTitle(trans('plugins-review::review.list'));

        return $dataTable->renderTable(['title' => trans('plugins-review::review.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle(trans('plugins-review::review.create'));

        return view('plugins-review::create');
    }

    /**
     * Insert new Review into database
     *
     * @param ReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(ReviewRequest $request)
    {
        $review = $this->reviewRepository->createOrUpdate($request->input());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, REVIEW_MODULE_SCREEN_NAME, $request, $review);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.review.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.review.edit', $review->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getEdit($id)
    {
        $review = $this->reviewRepository->findById($id);
        if (empty($review)) {
            abort(404);
        }

        page_title()->setTitle(trans('plugins-review::review.edit') . ' #' . $id);

        return view('plugins-review::edit', compact('review'));
    }

    /**
     * @param $id
     * @param ReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postEdit($id, ReviewRequest $request)
    {
        $review = $this->reviewRepository->findById($id);
        if (empty($review)) {
            abort(404);
        }
        $review->fill($request->input());

        $this->reviewRepository->createOrUpdate($review);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, REVIEW_MODULE_SCREEN_NAME, $request, $review);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.review.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.review.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author TrinhLe
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $review = $this->reviewRepository->findById($id);
            if (empty($review)) {
                abort(404);
            }
            $this->reviewRepository->delete($review);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, REVIEW_MODULE_SCREEN_NAME, $request, $review);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }

    /**
     * [postCommentReview description]
     * @param  Request $request [description]
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCommentReview($reviewId, PostReviewRequest $request, BaseHttpResponse $response){
        try{
            $comment = $this->reviewCommentRepository->getModel();
            $comment->fill([
                'review_id' => (int)$reviewId,
                'content'   => $request->get('content'),
                'is_admin'  => true
            ]);

            $comment->author()->associate(auth()->user());
            $this->reviewCommentRepository->createOrUpdate($comment);

            return $response
                ->setMessage(trans('core-base::notices.create_success_message'));
        }catch(\Exception $ex){
            info($ex->getMessage());
            return $response
                ->setError()
                ->setMessage(trans('cannot write a comment. Please try again.'));   
        }
    }
}
