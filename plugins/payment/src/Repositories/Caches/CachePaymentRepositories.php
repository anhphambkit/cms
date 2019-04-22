<?php

namespace Plugins\Payment\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Payment\Repositories\Interfaces\PaymentRepositories;

class CachePaymentRepositories extends CacheAbstractDecorator implements PaymentRepositories
{
    /**
     * @var PaymentRepositories
     */
    protected $repository;

    /**
     * PaymentCacheDecorator constructor.
     * @param PaymentRepositories $repository
     * @author TrinhLe
     */
    public function __construct(PaymentRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Payment"; # Please setup reference name of cache.
    }
}
