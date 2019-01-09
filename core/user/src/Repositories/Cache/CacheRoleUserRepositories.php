<?php
namespace Core\User\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\User\Repositories\Interfaces\RoleUserRepositories;

class CacheRoleUserRepositories extends CacheAbstractDecorator implements RoleUserRepositories
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
    public function __construct(RoleUserRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
