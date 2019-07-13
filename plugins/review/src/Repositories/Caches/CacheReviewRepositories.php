<?php

namespace Plugins\Review\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Review\Repositories\Interfaces\ReviewRepositories;

class CacheReviewRepositories extends CacheAbstractDecorator implements ReviewRepositories
{
    /**
     * @var ReviewRepositories
     */
    protected $repository;

    /**
     * ReviewCacheDecorator constructor.
     * @param ReviewRepositories $repository
     * @author TrinhLe
     */
    public function __construct(ReviewRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Review"; # Please setup reference name of cache.
    }
}
