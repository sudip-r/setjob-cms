<?php

namespace App\AlterBase\Repositories\Member;

use App\AlterBase\Repositories\Repository;

class MemberRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    public function getModel()
    {
        return 'App\AlterBase\Models\Member\Member';
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function searchMembers(
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
                ->orWhere('name', 'like', '%' . $searchCondition . '%')
                ->orWhere('email', 'like', $searchCondition);
        });

        return $q->orderBy($orderBy, $orderType)->paginate($limit, $columns);
    }

}
