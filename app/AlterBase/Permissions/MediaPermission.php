<?php

namespace App\AlterBase\Permissions;


use App\AlterBase\StorePermissions;

class MediaPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Media',
            'slug' => 'cms::medias',
            'description' => 'Media management module',
            'icon_class' => 'fa-image'
        ],
        'actions' => [
            [
                'name' => 'View all media',
                'slug' => 'cms::medias.index',
                'description' => 'Allow to view all medias.',
                'view_on_sidebar' => true,
                'menu_name' => "All Media"
            ],
            [
                'name' => 'Create media',
                'slug' => 'cms::medias.create',
                'description' => 'Allow to create new media.',
            ],
            [
                'name' => 'Update media',
                'slug' => 'cms::medias.update',
                'description' => 'Allow to update media.'
            ],
            [
                'name' => 'Delete media',
                'slug' => 'cms::medias.delete',
                'description' => 'Allow to delete media.'
            ]
        ]
    ];

    /**
     * Store permissions related to medias module
     *
     */
    public function store()
    {
        return StorePermissions::add($this->permissions);
    }
}