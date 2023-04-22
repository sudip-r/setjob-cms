<?php

namespace App\AlterBase\Repositories\Job;

use App\AlterBase\Repositories\Repository;

class JobRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    public function getModel()
    {
        return 'App\AlterBase\Models\Job\Job';
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function searchPost(
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

        $q = $q->where(function ($query) use ($searchCondition) {
            $query->where('id', '=', $searchCondition)
                ->orWhere('title', 'like', '%' . $searchCondition . '%')
                ->orWhere('summary', 'like', '%' . $searchCondition . '%');
        });

        return $q->orderBy($orderBy, $orderType)->paginate($limit, $columns);
    }

}
