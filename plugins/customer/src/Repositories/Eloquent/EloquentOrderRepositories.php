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
        try {
            return $this->model->insertGetId($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}