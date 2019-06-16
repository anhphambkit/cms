<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface LookBookRepositories extends RepositoryInterface{
    /**
     * @param string $type
     * @param bool $isMain
     * @param int $take
     * @param array $businessTypes
     * @param array $spaces
     * @param array $exceptBusinessType
     * @param array $productIds
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0, array $businessTypes = [], array $spaces = [], array $exceptBusinessType = [], array $productIds = []);
}