<?php

namespace Core\User\Repositories\Caches;

use Core\User\Repositories\Interfaces\RoleInterface;
use Core\Master\Repositories\Caches\CacheAbstractDecorator;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    /**
     * @var RoleInterface
     */
    protected $repository;

    /**
     * RoleCacheDecorator constructor.
     * @param RoleInterface $repository
     * @author TrinhLe
     */
    public function __construct(RoleInterface $repository)
    {
        $this->repository = $repository;
        $this->entityName = 'user-role'; # Please setup reference name of cache.
    }

    /**
     * @param $name
     * @param $id
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
