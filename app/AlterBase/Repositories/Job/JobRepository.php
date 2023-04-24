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

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function paginateWithFilters(
        $filters,
        $condition,
        $searchCondition,
        $orderBy = 'id',
        $orderType = 'desc',
        $limit = 40,
        $column = ['*'],
        $page = 1
    ) {
        $q = $this->model
            ->where($condition);

        if ($searchCondition != "") {
            $q = $q->where('title', 'like', '%' . $searchCondition . '%');
        }
        if (count($filters) > 0) {
            $q = $q->where(function ($query) use ($filters) {
                if ($filters["type"]["full_time"] == "true") {
                    $query->orWhere('type', 'like', "Full time");
                }
                if ($filters["type"]["part_time"] == "true") {
                    $query->orWhere('type', 'like', "Part time");
                }
                if ($filters["type"]["contract"] == "true") {
                    $query->orWhere('type', 'like', "Contract");
                }
                if ($filters["type"]["freelance"] == "true") {
                    $query->orWhere('type', 'like', "Freelance");
                }
            });

            if ($filters["location"]["id"] != "") {
                $q = $q->where(function ($query) use ($filters) {
                    $query = $query->where('location', '=', $filters["location"]["id"]);
                });
            }

            if ($filters["company"]["id"] != "") {
                $q = $q->where(function ($query) use ($filters) {
                    $query = $query->where('user_id', '=', $filters["company"]["id"]);
                });
            }

            if ($filters["salary"]["max"] != 0) {
                $q = $q->where(function ($query) use ($filters) {
                    $query = $query->where('salary_min', '<=', $filters["salary"]["max"])
                        ->where('salary_max', '>=', $filters["salary"]["max"]);
                });
            }

        }

        $q = $q->orderBy($orderBy, $orderType)
            ->select($column);

        return $q;
    }

    /**
     * Get the resources with given condition(s)
     *
     * @param $conditions
     * @param array $columns
     * @return Collection
     */
    public function paginateWithSearch(
        $condition,
        $searchCondition,
        $orderBy = 'id',
        $orderType = 'desc',
        $limit = 40,
        $column = ['*'],
        $page = 1
    ) {
        $q = $this->model
            ->where($condition);

        if ($searchCondition != "") {
            $q = $q->where('title', 'like', '%' . $searchCondition . '%');
        }
        
        $q = $q->orderBy($orderBy, $orderType)
            ->select($column)
            ->paginate($limit, null, 'page', $page);

        return $q;
    }

}
