<?php
namespace Plugins\Customer\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;

class CacheOrderRepositories extends CacheAbstractDecorator implements OrderRepositories
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
    public function __construct(OrderRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'Cache-Order'; # Please setup reference name of cache.
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createNewInvoiceOrder(array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
