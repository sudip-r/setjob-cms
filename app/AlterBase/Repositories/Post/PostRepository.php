<?php

namespace App\AlterBase\Repositories\Post;

use App\AlterBase\Models\Category\Category;
use App\AlterBase\Repositories\Repository;

class PostRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    public function getModel()
    {
        return 'App\AlterBase\Models\Post\Post';
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
     * Get posts by category id
     *
     * @param $id
     * @return Collection
     */
    public function postByCategory($id, $home = true)
    {
        $category = Category::find($id);
        $limit = 30;
        if ($home) {
            $limit = config('cms.' . $category->slug) ?? 5;
        }

        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->where('pc.category_id', $id)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on', 'p.video')
            ->with('cats')
            ->limit($limit)
            ->get();
    }

    /**
     * Get posts by category id
     *
     * @param $id
     * @return Collection
     */
    public function postBySubCategory($id, $home = true)
    {
        $category = Category::find($id);
        $limit = 30;
        if ($home) {
            $limit = config('cms.' . $category->slug) ?? 5;
        }

        $subs = [];

        foreach ($category->subCategories() as $cat) {
            $subs[] = $cat->id;
        }

        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->whereIn('pc.category_id', $subs)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on')
            ->with('cats')
            ->limit($limit)
            ->get();
    }

    /**
     * Get posts by parent id
     *
     * @param $id
     * @return Collection
     */
    public function postByParent($id, $home = true)
    {
        $category = Category::find($id);

        $subs = [];

        if($category->parent > 0)
        {
            $parent = $category->parent();
            foreach ($parent->subCategories() as $cat) {
                $subs[] = $cat->id;
            }
        }

        foreach ($category->subCategories() as $cat) {
            $subs[] = $cat->id;
        }
        $limit = 30;
        if ($home) {
            $limit = config('cms.' . $parent->slug) ?? 5;
        }

        $subs = array_unique($subs);

        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->whereIn('pc.category_id', $subs)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on', 'p.video')
            ->with('cats')
            ->limit($limit)
            ->distinct()
            ->get();
    }

    /**
     * Get posts by parent id
     *
     * @param $id
     * @return Collection
     */
    public function paginatePostByParent($id, $home = true)
    {
        $category = Category::find($id);

        $subs = [];

        if($category->parent > 0)
        {
            $parent = $category->parent();
            foreach ($parent->subCategories() as $cat) {
                $subs[] = $cat->id;
            }
        }

        foreach ($category->subCategories() as $cat) {
            $subs[] = $cat->id;
        }
        $limit = 30;
        if ($home) {
            $limit = config('cms.' . $parent->slug) ?? 5;
        }

        $subs = array_unique($subs);

        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->whereIn('pc.category_id', $subs)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on')
            ->with('cats')
            ->distinct()
            ->paginate($limit);
    }

     /**
     * Get posts by category id
     *
     * @param $id
     * @return Collection
     */
    public function paginatePostByCategory($id)
    {
        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->where('pc.category_id', $id)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on')
            ->with('cats')
            ->paginate(30);
    }

    /**
     * Related posts by category
     * 
     * @param $category
     * @param $post
     * @return Collection
     */
    public function relatedPosts($category, $post)
    {
        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->where('pc.category_id', $category)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->where('p.id', '!=', $post)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on')
            ->with('cats')
            ->distinct()
            ->limit(5)
            ->get();
    }

    /**
     * Related posts by category
     * 
     * @param $category
     * @param $post
     * @return Collection
     */
    public function otherProject($category, $post)
    {
        return $this->model->from('posts as p')
            ->join('post_categories as pc', 'pc.post_id', 'p.id')
            ->join('categories as c', 'c.id', 'pc.category_id')
            ->where('c.parent', 2)
            ->where('p.publish', 1)
            ->where('p.trash', 0)
            ->where('p.id', '!=', $post)
            ->orderBy('p.published_on', 'desc')
            ->select('p.id', 'p.title', 'p.summary', 'p.image', 'p.slug', 'p.published_on')
            ->with('cats')
            ->distinct()
            ->limit(5)
            ->get();
    }

}
