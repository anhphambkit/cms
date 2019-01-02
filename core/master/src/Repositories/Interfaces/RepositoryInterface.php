<?php

namespace Core\Master\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Get empty model.
     * @return mixed
     * @author TrinhLe
     */
    public function setModel($model);

    /**
     * Get empty model.
     * @return mixed
     * @author TrinhLe
     */
    public function getModel();

    /**
     * Get table name.
     *
     * @return string
     * @author TrinhLe
     */
    public function getTable();

    /**
     * Find a single entity by key value.
     *
     * @param array $condition
     * @param array $select
     * @param array $with
     * @return mixed
     * @author TrinhLe
     */
    public function getFirstBy(array $condition = [], array $select = [], array $with = []);

    /**
     * Retrieve model by id regardless of status.
     *
     * @param $id
     * @param array $with
     * @return mixed
     * @author TrinhLe
     */
    public function findById($id, array $with = []);

    /**
     * @param string $column
     * @param string $key
     * @return mixed
     * @author TrinhLe
     */
    public function pluck($column, $key = null);

    /**
     * Get all models.
     *
     * @param array $with Eager load related models
     * @return mixed
     * @author TrinhLe
     */
    public function all(array $with = []);

    /**
     * Get all models by key/value.
     *
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return array
     * @author TrinhLe
     */
    public function allBy(array $condition, array $with = [], array $select = ['*']);

    /**
     * Get single model by Slug.
     *
     * @param string $slug slug
     * @param array $with related tables
     * @return mixed
     * @author TrinhLe
     */
    public function bySlug($slug, array $with = []);

    /**
     * @param array $data
     * @return mixed
     * @author TrinhLe
     */
    public function create(array $data);

    /**
     * Create a new model.
     *
     * @param Model|array $data
     * @param array $condition
     * @return false|Model
     * @author TrinhLe
     */
    public function createOrUpdate($data, $condition = []);

    /**
     * Delete model.
     *
     * @param Model $model
     * @return bool
     * @author TrinhLe
     */
    public function delete(Model $model);

    /**
     * @param array $data
     * @param array $with
     * @return mixed
     * @author TrinhLe
     */
    public function firstOrCreate(array $data, array $with = []);

    /**
     * @param array $condition
     * @param array $data
     * @return mixed
     * @author TrinhLe
     */
    public function update(array $condition, array $data);

    /**
     * @param array $select
     * @param array $condition
     * @return mixed
     * @author TrinhLe
     */
    public function select(array $select = ['*'], array $condition = []);

    /**
     * @param array $condition
     * @return mixed
     * @author TrinhLe
     */
    public function deleteBy(array $condition = []);

    /**
     * @param array $condition
     * @return mixed
     * @author TrinhLe
     */
    public function count(array $condition = []);

    /**
     * @param $column
     * @param array $value
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getByWhereIn($column, array $value = [], array $args = []);

    /**
     * @param array $data
     * @return bool
     * @author TrinhLe
     */
    public function insert(array $data);
}
