<?php
namespace Core\User\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\User\Repositories\Interfaces\RoleFlagRepositories;

class CacheRoleFlagRepositories extends CacheAbstractDecorator implements RoleFlagRepositories
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
    public function __construct(RoleFlagRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
