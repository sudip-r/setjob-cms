<?php

namespace App\AlterBase\Permissions;

use App\alterBase\StorePermissions;

class PagePermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Page',
            'slug' => 'cms::pages',
            'description' => 'Page Management',
            'icon_class' => 'fas fa-file-alt',
        ],
        'actions' => [
            [
                'name' => 'View all pages',
                'slug' => 'cms::pages.index',
                'description' => 'Allow to view all pages.',
                'view_on_sidebar' => true,
                'menu_name' => "All Pages",
            ],
            [
                'name' => 'Create page',
                'slug' => 'cms::pages.create',
                'description' => 'Allow to create new page.',
                'view_on_sidebar' => false,
                'menu_name' => "Add Page",
            ],
            [
                'name' => 'Update page',
                'slug' => 'cms::pages.update',
                'description' => 'Allow to update page.',
            ],
            [
                'name' => 'Delete page',
                'slug' => 'cms::pages.delete',
                'description' => 'Allow to delete page.',
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
