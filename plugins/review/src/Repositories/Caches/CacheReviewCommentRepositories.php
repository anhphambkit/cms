<?php
namespace Plugins\Review\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Review\Repositories\Interfaces\ReviewCommentRepositories;

class CacheReviewCommentRepositories extends CacheAbstractDecorator implements ReviewCommentRepositories
{
    /**
     * @var ApplicationInterface
     */
    protected $repository;

    /**
     * ApplicationCacheDecorator constructor.
     * @param ApplicationInterface $repository
     * @author TrinhLe
     */
    public function __construct(ReviewCommentRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'Cache-Review'; # Please setup reference name of cache.
    }
}
