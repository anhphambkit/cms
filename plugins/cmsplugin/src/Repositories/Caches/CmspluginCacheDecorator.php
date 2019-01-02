<?php

namespace Plugins\Cmsplugin\Repositories\Caches;

use Core\Master\Repositories\Caches\CacheAbstractDecorator;
use Core\Master\Services\Cache\CacheInterface;
use Plugins\Cmsplugin\Repositories\Interfaces\CmspluginInterface;

class CmspluginCacheDecorator extends CacheAbstractDecorator implements CmspluginInterface
{
    /**
     * @var CmspluginInterface
     */
    protected $repository;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * CmspluginCacheDecorator constructor.
     * @param CmspluginInterface $repository
     * @param CacheInterface $cache
     * @author Sang Nguyen
     */
    public function __construct(CmspluginInterface $repository, CacheInterface $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }
}
