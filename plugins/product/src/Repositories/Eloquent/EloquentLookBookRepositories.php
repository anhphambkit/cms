<?php
/**
 * LookBook repository implemented
 */
namespace Plugins\Product\Repositories\Eloquent;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentLookBookRepositories extends RepositoriesAbstract implements LookBookRepositories {
    /**
     * @param string $type
     * @param bool $isMain
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false) {
        $query = $this->model
                    ->select('look_books.*')
                    ->where('type_layout', $type)
                    ->where('is_main', $isMain)
                    ->with('lookBookTags', 'lookBookSpaces', 'lookBookBusiness', 'lookBookSpacesBelong')
                    ->get();
//        dd($query);
        return $query;
    }
}