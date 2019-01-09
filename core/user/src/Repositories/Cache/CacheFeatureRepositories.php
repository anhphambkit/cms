<?php
namespace Core\User\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\User\Repositories\Interfaces\FeatureRepositories;

class CacheFeatureRepositories extends CacheAbstractDecorator implements FeatureRepositories
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
    public function __construct(FeatureRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
