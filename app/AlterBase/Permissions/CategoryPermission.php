<?php

namespace App\AlterBase\Permissions;


use App\AlterBase\StorePermissions;

class CategoryPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Category',
            'slug' => 'cms::categories',
            'description' => 'Posts Management',
            'icon_class' => 'fa-bars'
        ],
        'actions' => [
            [
                'name' => 'View all categories',
                'slug' => 'cms::categories.index',
                'description' => 'Allow to view all categories.',
                'view_on_sidebar' => true,
                'menu_name' => "All Categories"
            ],
            [
                'name' => 'Create category',
                'slug' => 'cms::categories.create',
                'description' => 'Allow to create new category.',
                'view_on_sidebar' => true,
                'menu_name' => "Add Category"
            ],
            [
                'name' => 'Update category',
                'slug' => 'cms::categories.update',
                'description' => 'Allow to update category.'
            ],
            [
                'name' => 'Delete category',
                'slug' => 'cms::categories.delete',
                'description' => 'Allow to delete category.'
            ]
        ]
    ];

    /**
     * Store permissions related to categories module
     *
     */
    public function store()
    {
        return StorePermissions::add($this->permissions);
    }
}