<?php
namespace Core\Master\Repositories\Eloquent;
use Core\Master\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class RepositoriesAbstract implements RepositoryInterface
{
    /**
     * @var Eloquent
     */
    protected $originalModel;

    /**
     * @var Eloquent
     */
    protected $model;

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel($model)
    {
        $this->model = $model;

        if(empty($this->originalModel))
            $this->originalModel = $model;
    }

    /**
     * @return $this
     */
    public function resetModel()
    {
        $this->model = $this->originalModel;
        return $this;
    }

    /**
     * Get table name.
     *
     * @return string
     * @author Sang Nguyen
     */
    public function getTable()
    {
        return $this->model->getTable();
    }

    /**
     * Find a single entity by key value.
     *
     * @param array $condition
     * @param array $select
     * @param array $with
     * @return mixed
     * @author Sang Nguyen
     */
    public function getFirstBy(array $condition = [], array $select = ['*'], array $with = [])
    {

        $this->make($with);

        if (!empty($select)) {
            $data = $this->model->where($condition)->select($select)->first();
        } else {
            $data = $this->model->where($condition)->first();
        }

        $this->resetModel();

        return $data;
    }

    /**
     * Retrieve model by id regardless of status.
     *
     * @param $id
     * @param array $with
     * @return mixed
     * @author Sang Nguyen
     */
    public function findById($id, array $with = [])
    {

        $data = $this->make($with)->where('id', $id)->first();
        $this->resetModel();
        return $data;
    }

    /**
     * Get all models.
     *
     * @param array $with Eager load related models
     * @return mixed
     * @author Sang Nguyen
     */
    public function all(array $with = [])
    {

        $data = $this->make($with)->get();

        $this->resetModel();

        return $data;
    }

    /**
     * @param string $column
     * @param string $key
     * @return mixed
     * @author Sang Nguyen
     */
    public function pluck($column, $key = null)
    {

        $data = $this->model->pluck($column, $key)->all();

        $this->resetModel();

        return $data;
    }

    /**
     * Get all models by key/value.
     *
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     * @author Sang Nguyen
     */
    public function allBy(array $condition, array $with = [], array $select = ['*'])
    {

        $this->applyConditions($condition);

        $data = $this->make($with)->select($select)->get();
        $this->resetModel();
        return $data;
    }

    /**
     * Get single model by Slug.
     *
     * @param string $slug slug
     * @param array $with related tables
     * @return mixed
     * @author Sang Nguyen
     */
    public function bySlug($slug, array $with = [])
    {

        $data = $this->make($with)->where('slug', '=', $slug)->first();

        $this->resetModel();

        return $data;
    }

    /**
     * @param array $data
     * @return mixed
     * @author Sang Nguyen
     */
    public function create(array $data)
    {
        $data = $this->model->create($data);
        $this->resetModel();
        return $data;
    }

    /**
     * Create a new model.
     *
     * @param $data
     * @param array $condition
     * @return false|Model
     * @author Sang Nguyen
     */
    public function createOrUpdate($data, $condition = [])
    {
        /**
         * @var Model $item
         */
        if (is_array($data)) {
            if (empty($condition)) {
                $item = new $this->model;
            } else {
                $item = $this->getFirstBy($condition);
            }
            if (empty($item)) {
                $item = new $this->model;
            }

            $item = $item->fill($data);
        } elseif ($data instanceof Model) {
            $item = $data;
        } else {
            return false;
        }

        if ($item->save()) {
            $this->resetModel();
            return $item;
        }

        $this->resetModel();

        return false;
    }

    /**
     * Delete model.
     *
     * @param Model $model
     * @return bool
     * @author Sang Nguyen
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * @param array $data
     * @param array $with
     * @return mixed
     * @author Sang Nguyen
     */
    public function firstOrCreate(array $data, array $with = [])
    {

        $data = $this->model->firstOrCreate($data, $with);

        $this->resetModel();

        return $data;
    }

    /**
     * @param array $condition
     * @param array $data
     * @return mixed
     * @author Sang Nguyen
     */
    public function update(array $condition, array $data)
    {
        $data = $this->model->where($condition)->update($data);
        $this->resetModel();
        return $data;
    }

    /**
     * @param array $select
     * @param array $condition
     * @return mixed
     * @author Sang Nguyen
     */
    public function select(array $select = ['*'], array $condition = [])
    {
        $data = $this->model->where($condition)->select($select);
        $this->resetModel();
        return $data;
    }

    /**
     * @param array $condition
     * @return bool
     * @author Sang Nguyen
     */
    public function deleteBy(array $condition = [])
    {
        $this->applyConditions($condition);

        $data = $this->model->get();

        if (empty($data)) {
            return false;
        }
        foreach ($data as $item) {
            $item->delete();
        }
        $this->resetModel();
        return true;
    }

    /**
     * @param array $condition
     * @return mixed
     * @author Sang Nguyen
     */
    public function count(array $condition = [])
    {
        $this->applyConditions($condition);
        $data = $this->model->count();

        $this->resetModel();

        return $data;
    }

    /**
     * @param $column
     * @param array $value
     * @param array $args
     * @return \Illuminate\Database\Eloquent\Collection|LengthAwarePaginator|mixed
     * @author Sang Nguyen
     */
    public function getByWhereIn($column, array $value = [], array $args = [])
    {
        $this->model = $this->model->whereIn($column, $value);

        if (!empty(array_get($args, 'where'))) {
            $this->applyConditions($args['where']);
        }

        if (!empty(array_get($args, 'paginate'))) {
            $data = $this->model->paginate($args['paginate']);
        } elseif (!empty(array_get($args, 'limit'))) {
            $data = $this->model->limit($args['limit']);
        } else {
            $data = $this->model->get();
        }

        $this->resetModel();

        return $data;
    }
    
    /**
     * @param array $where
     */
    protected function applyConditions(array $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                switch (strtoupper($condition)) {
                    case 'IN':
                        $this->model = $this->model->whereIn($field, $val);
                        break;
                    case 'NOT_IN':
                        $this->model = $this->model->whereNotIn($field, $val);
                        break;
                    default:
                        $this->model = $this->model->where($field, $condition, $val);
                        break;
                }
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function advancedGet(array $params = [])
    {

        $params = array_merge([
            'condition' => [],
            'order_by' => [],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1,
            ],
            'select' => ['*'],
            'with' => [],
        ], $params);

        $this->applyConditions($params['condition']);

        if ($params['select']) {
            $this->model = $this->model->select($params['select']);
        }

        foreach ($params['order_by'] as $column => $direction) {
            $this->model = $this->model->orderBy($column, $direction);
        }

        foreach ($params['with'] as $with) {
            $this->model = $this->model->with($with);
        }

        if ($params['take'] == 1) {
            $result = $this->model->first();
        } elseif ($params['take']) {
            $result = $this->model->take($params['take'])->get();
        } elseif ($params['paginate']['per_page']) {
            $result = $this->model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        } else {
            $result = $this->model->get();
        }

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $data
     * @return bool
     * @author Sang Nguyen
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }
}