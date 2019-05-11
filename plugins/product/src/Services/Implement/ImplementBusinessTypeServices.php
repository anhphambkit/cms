<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-10
 * Time: 18:04
 */

namespace Plugins\Product\Services\Implement;

use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Services\BusinessTypeServices;

class ImplementBusinessTypeServices implements BusinessTypeServices {

    private $repository;

    /**
     * ImplementBusinessTypeServices constructor.
     * @param BusinessTypeRepositories $businessTypeRepositories
     */
    public function __construct(BusinessTypeRepositories $businessTypeRepositories)
    {
        $this->repository = $businessTypeRepositories;
    }

    /**
     * @return mixed
     */
    public function getAllBusinessTypeGroupByParent() {
        return $this->repository->getAllBusinessTypeGroupByParent();
    }
}