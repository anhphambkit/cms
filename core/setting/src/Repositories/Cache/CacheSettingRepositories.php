<?php
namespace Core\Setting\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Setting\Repositories\SettingRepositories;

class CacheSettingRepositories extends CacheAbstractDecorator implements SettingRepositories
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
    public function __construct(SettingRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'cms-setting'; # Please setup reference name of cache.
    }
}
