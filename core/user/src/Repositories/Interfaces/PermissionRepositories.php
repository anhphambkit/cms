<?php
namespace Core\User\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface PermissionRepositories extends RepositoryInterface{
    /**
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getVisibleFeatures(array $select = ['*']);

    /**
     * @param array $select
     * @return mixed
     * @author TrinhLe
     */
    public function getVisiblePermissions(array $select = ['*']);
}