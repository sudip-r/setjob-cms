<?php

namespace App\AlterBase\Repositories\Page;

use App\AlterBase\Repositories\Repository;

class PageRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    function getModel()
    {
        return 'App\alterBase\Models\Page\Page';
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function searchPage(
        $conditions = [],
        $searchCondition,
        $orderBy = 'id',
        $orderType = 'desc',
        $columns = array('*'),
        $limit = 40
    ) {
        $q = $this->model;
        if (count($conditions) > 0)
            $q = $this->model->where($conditions);

        $q = $q->where(function ($query) use ($searchCondition) {
            $query->where('id', '=', $searchCondition)
                ->orWhere('page', 'like', '%' . $searchCondition . '%');
        });

        return $q->orderBy($orderBy, $orderType)->paginate($limit, $columns);
    }
}