<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface LookBookRepositories extends RepositoryInterface{
    /**
     * @param string $type
     * @param bool $isMain
     * @param int $take
     * @param int $businessTypeId
     * @param int $spaceId
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0, int $businessTypeId = 0, int $spaceId = 0);
}