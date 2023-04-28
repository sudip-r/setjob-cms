<?php

namespace App\AlterBase\Permissions;

use App\AlterBase\StorePermissions;

class JobPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Job',
            'slug' => 'cms::jobs',
            'description' => 'Job management module',
            'icon_class' => 'fas fa-landmark',
        ],
        'actions' => [
            [
                'name' => 'View all jobs',
                'slug' => 'cms::jobs.index',
                'description' => 'Allow to view all jobs.',
                'view_on_sidebar' => true,
                'menu_name' => "All Jobs",
            ],
            [
                'name' => 'Create job',
                'slug' => 'cms::jobs.create',
                'description' => 'Allow to create new job.',
                'view_on_sidebar' => true,
                'menu_name' => "Add Job",
            ],
            [
                'name' => 'Update job',
                'slug' => 'cms::jobs.update',
                'description' => 'Allow to update job.',
            ],
            [
                'name' => 'Delete job',
                'slug' => 'cms::jobs.delete',
                'description' => 'Allow to delete job.',
            ],
            [
                'name' => 'Publish job',
                'slug' => 'cms::jobs.status',
                'description' => 'Allow to publish job.',
            ],
        ],
    ];

    /**
     * Store permissions related to jobs module
     *
     */
    public function store()
    {
        return StorePermissions::add($this->permissions);
    }
}
