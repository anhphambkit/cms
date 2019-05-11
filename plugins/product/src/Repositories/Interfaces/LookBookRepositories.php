<?php
namespace Plugins\Product\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface LookBookRepositories extends RepositoryInterface{
    /**
     * @param string $type
     * @param bool $isMain
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false);
}