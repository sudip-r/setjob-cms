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
    public function searchJob(
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
            $q = $q->where(function ($query) use ($searchCondition) {
                $query = $query->where('title', 'like', '%' . $searchCondition . '%')
                    ->orWhere('location_text', 'like', $searchCondition . '%');
            });
        }
        if (count($filters) > 0) {
            $q = $q->where(function ($query) use ($filters) {
                if (isset($filters["type"]["workshop"]) && $filters["type"]["workshop"] == "true") {
                    $query->orWhere('type', 'like', "Workshop");
                }
                if (isset($filters["type"]["on_site"]) && $filters["type"]["on_site"] == "true") {
                    $query->orWhere('type', 'like', "On Site");
                }
                if (isset($filters["type"]["abroad"]) && $filters["type"]["abroad"] == "true") {
                    $query->orWhere('type', 'like', "Abroad");
                }
                if (isset($filters["type"]["various"]) && $filters["type"]["various"] == "true") {
                    $query->orWhere('type', 'like', "Various");
                }
            });

            $q = $q->where(function ($query) use ($filters) {
                if (isset($filters["salary_type"]["per_annum"]) && $filters["salary_type"]["per_annum"] == "true") {
                    $query->orWhere('salary_type', 'like', "Per Annum");
                }
                if (isset($filters["salary_type"]["per_hour"]) && $filters["salary_type"]["per_hour"] == "true") {
                    $query->orWhere('salary_type', 'like', "Per Hour");
                }
                if (isset($filters["salary_type"]["freelance"]) && $filters["salary_type"]["freelance"] == "true") {
                    $query->orWhere('salary_type', 'like', "Freelance");
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

            if ($filters["category"]["id"] != "") {
                $q = $q->where(function ($query) use ($filters) {
                    $query = $query->where('category_id', '=', $filters["category"]["id"]);
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
            $q = $q->where(function ($query) use ($searchCondition) {
                $query = $query->where('title', 'like', '%' . $searchCondition . '%')
                    ->orWhere('location_text', 'like', $searchCondition . '%');
            });
        }
        
        $q = $q->orderBy($orderBy, $orderType)
            ->select($column)
            ->paginate($limit, null, 'page', $page);

        return $q;
    }

}
