<?php
namespace Core\SeoHelper\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\SeoHelper\Repositories\Interfaces\MetaBoxRepositories;

class CacheMetaBoxRepositories extends CacheAbstractDecorator implements MetaBoxRepositories
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
    public function __construct(MetaBoxRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
