<?php

namespace App\AlterBase\Repositories\User;

use App\AlterBase\Repositories\Repository;

class UserRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    public function getModel()
    {
        return 'App\AlterBase\Models\User\User';
    }

    /**
     * Get all admin users
     * 
     * @return Collection
     */
    public function getAllAdmin()
    {
        return $this->model->from('users')
            ->where('guard', 'web')
            ->get();
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function searchUsers(
        $conditions = [],
        $searchCondition,
        $orderBy = 'id',
        $orderType = 'desc',
        $columns = array('*'),
        $limit = 40
    ) {
        $q = $this->model;
        if (count($conditions) > 0) {
            $q = $this->model->where($conditions);
        }
        $q = $q->where('name', 'like', $searchCondition . '%');

        return $q->orderBy($orderBy, $orderType)->paginate($limit, $columns);
    }
}
