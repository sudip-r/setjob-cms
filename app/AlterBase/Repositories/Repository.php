<?php

namespace App\AlterBase\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;


/**
 * Class Repository
 * @package App\MNepal\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Repository constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->model = $this->makeModel($app);
    }

    /**
     * Get model name with namespace
     *
     * @return String
     */
    abstract function getModel();



    /**
     * Get model
     *
     * @param Application $app
     * @return Model
     */
    protected function makeModel($app)
    {
        return $app->make($this->getModel());
    }

    /**
     * Get all resources
     * @param array $columns
     * @return Collection
     */
    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    /**
     * Get paginated resources with given limit
     * @param int $limit
     * @param string $orderBy
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit = 15, $order = "id", $orderBy = 'desc')
    {
        return $this->model
            ->orderBy($order, $orderBy)
            ->paginate($limit);
    }
    /**
     * Store newly created resource
     * @param array $data
     * @return Model
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update specific resource.
     * @param array $data
     * @param $id
     * @return bool
     */
    public function update($id,array $data)
    {
        return $this->model->find($id)->update($data);
    }

    /**
     * Update specific resource.
     * @param $field
     * @param $value
     * @param array $data
     * @return bool
     */
    public function updateWith($field, $value,array $data)
    {
        return $this->model->where($field, $value)->update($data);
    }

    /**
     * Delete specific resource
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Find specific resource
     * @param $id
     * @param array $columns
     * @return Object
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find specific resource by given attribute
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return Object
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Find all the resources by given attribute
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return Object
     */
    public function getBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->get($columns);
    }

    /**
     * Get list of resources
     *
     * @param $id
     * @param $value
     * @return mixed
     */
    public function pluck($id, $value){
        return $this->model->pluck($id, $value);
    }

    /**
     * Find an object with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Object
     */
    public function findWithCondition($conditions, $columns = array('*'))
    {
        return $this->model->where($conditions)->first($columns);
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function getWithCondition(
        $conditions, 
        $orderBy='id', 
        $orderType = 'desc', 
        $columns = array('*')
    )
    {
        return $this->model->where($conditions)->orderBy($orderBy, $orderType)->get($columns);
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function getInArray(
        $conditions,
        $id,
        $array,
        $orderBy = 'id',
        $orderType = 'desc',
        $columns = array('*'),
        $limit = 10
    ) {
        return $this->model
            ->where($conditions)
            ->whereIn($id, $array)
            ->orderBy($orderBy, $orderType)
            ->limit($limit)
            ->get($columns);
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function paginateInArray(
        $conditions,
        $id,
        $array,
        $orderBy = 'id',
        $orderType = 'desc',
        $columns = array('*'),
        $limit = 10
    ) {
        return $this->model
            ->where($conditions)
            ->whereIn($id, $array)
            ->orderBy($orderBy, $orderType)
            ->select($columns)
            ->paginate($limit);
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function paginateWithCondition(
        $column,
        $condition,
        $orderBy = 'id',
        $orderType = 'desc',
        $limit = 40
    ) {
        return $this->model
            ->where($column, 'like', '%' . $condition . '%')
            ->orderBy($orderBy, $orderType)
            ->paginate($limit);
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function paginateWithMultipleCondition(
        $condition,
        $orderBy = 'id',
        $orderType = 'desc',
        $limit = 40,
        $column = ['*'],
        $page = 1
    ) {
        return $this->model
            ->where($condition)
            ->orderBy($orderBy, $orderType)
            ->select($column)
            ->paginate($limit, null, 'page', $page);
    }
}
