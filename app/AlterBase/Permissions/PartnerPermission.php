<?php

namespace App\AlterBase\Permissions;

use App\AlterBase\StorePermissions;

class PartnerPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Partner',
            'slug' => 'cms::partners',
            'description' => 'Partner Management',
            'icon_class' => 'fad fa-hands-helping',
        ],
        'actions' => [
            [
                'name' => 'View all partners',
                'slug' => 'cms::partners.index',
                'description' => 'Allow to view all partners.',
                'view_on_sidebar' => true,
                'menu_name' => "All Partners",
            ],
            [
                'name' => 'Create partner',
                'slug' => 'cms::partners.create',
                'description' => 'Allow to create new partner.',
                'view_on_sidebar' => false,
                'menu_name' => "Add Partner",
            ],
            [
                'name' => 'Update partner',
                'slug' => 'cms::partners.update',
                'description' => 'Allow to update partner.',
            ],
            [
                'name' => 'Delete partner',
                'slug' => 'cms::partners.delete',
                'description' => 'Allow to delete partner.',
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
