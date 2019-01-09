<?php
/**
 * Permission repository implemented
 */
namespace Core\User\Repositories\Eloquent;
use Core\User\Repositories\Interfaces\PermissionRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;

class EloquentPermissionRepositories extends RepositoriesAbstract implements PermissionRepositories {
	
	/**
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getVisibleFeatures(array $select = ['*'])
    {
        $data = $this->model->orderBy('name')
            ->whereIsFeature(1)
            ->whereFeatureVisible(1)
            ->select($select)
            ->get();
        $this->resetModel();

        return $data;
    }

    /**
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getVisiblePermissions(array $select = ['*'])
    {
        $data = $this->model->orderBy('name')
            ->whereFeatureVisible(1)
            ->select($select)
            ->get();
        $this->resetModel();
        return $data;
    }

}