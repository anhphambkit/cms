<?php

namespace Plugins\Review\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Plugins\Review\Requests\PostReviewRequest;
use Plugins\Review\Repositories\Interfaces\ReviewRepositories;
use Plugins\Review\Repositories\Interfaces\ReviewCommentRepositories;
use Core\Base\Responses\BaseHttpResponse;

class ReviewController extends BasePublicController
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
	 * [postReview description]
	 * @param  ReviewRequest $request [description]
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postReview($productId, PostReviewRequest $request, BaseHttpResponse $response)
	{
		try{
			$review = $this->reviewRepository->getModel();
			$review->fill([
				'product_id'  => (int)$productId,
				'content'     => $request->get('content'),
				'rating'      => (int)$request->get('rating'),
			]);

			$review->customer()->associate(get_current_customer());
			$this->reviewRepository->createOrUpdate($review);

			return $response
	            ->setMessage(trans('core-base::notices.create_success_message'));
		}catch(\Exception $ex){
			info($ex->getMessage());
			return $response
				->setError()
	            ->setMessage(trans('cannot write a review. Please try again.'));	
		}
	}

	/**
	 * [postReview description]
	 * @param  ReviewRequest $request [description]
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function postCommentReview($reviewId, PostReviewRequest $request, BaseHttpResponse $response)
	{
		try{
			$comment = $this->reviewCommentRepository->getModel();
			$comment->fill([
				'review_id'  => (int)$reviewId,
				'content'     => $request->get('content'),
			]);

			$comment->author()->associate(get_current_customer());
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