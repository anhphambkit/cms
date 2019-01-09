<?php
namespace Core\User\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\User\Repositories\Interfaces\PermissionRepositories;

class CachePermissionRepositories extends CacheAbstractDecorator implements PermissionRepositories
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
    public function __construct(PermissionRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }

    /**
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getVisibleFeatures(array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getVisiblePermissions(array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
