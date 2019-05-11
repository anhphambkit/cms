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
     * @param int $take
     * @param int $businessTypeId
     * @param int $spaceId
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0, int $businessTypeId = 0, int $spaceId = 0) {
        $query = $this->model
                    ->select('look_books.*')
                    ->leftJoin('look_book_business_type_space_relation', 'look_book_business_type_space_relation.look_book_id', '=', 'look_books.id')
                    ->where('type_layout', $type)
                    ->where('is_main', $isMain)
                    ->orderBy('created_at', 'desc');
        if ($spaceId)
            $query = $query->where('look_book_business_type_space_relation.space_id', $spaceId);

        if ($businessTypeId)
            $query = $query->where('look_book_business_type_space_relation.business_type_id', $businessTypeId);

        if ($take)
            $query = $query->take($take);
        return $query->get();
    }
}