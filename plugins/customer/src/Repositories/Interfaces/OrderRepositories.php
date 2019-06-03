<?php
namespace Plugins\Customer\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface OrderRepositories extends RepositoryInterface{
    /**
     * @param array $data
     * @return mixed
     */
    public function createNewInvoiceOrder(array $data);
}