<?php
/**
 * Order repository implemented
 */
namespace Plugins\Customer\Repositories\Eloquent;
use Plugins\Customer\Repositories\Interfaces\OrderRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentOrderRepositories extends RepositoriesAbstract implements OrderRepositories {
    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function createNewInvoiceOrder(array $data) {
        return $this->model->insertGetId($data);
    }
}