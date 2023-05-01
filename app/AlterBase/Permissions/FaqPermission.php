<?php

namespace App\AlterBase\Permissions;

use App\AlterBase\StorePermissions;

class FaqPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Faq',
            'slug' => 'cms::faqs',
            'description' => 'Faq Management',
            'icon_class' => 'fas fa-question',
        ],
        'actions' => [
            [
                'name' => 'View all faqs',
                'slug' => 'cms::faqs.index',
                'description' => 'Allow to view all faqs.',
                'view_on_sidebar' => true,
                'menu_name' => "All Faqs",
            ],
            [
                'name' => 'Create faq',
                'slug' => 'cms::faqs.create',
                'description' => 'Allow to create new faq.',
                'view_on_sidebar' => false,
                'menu_name' => "Add Faq",
            ],
            [
                'name' => 'Update faq',
                'slug' => 'cms::faqs.update',
                'description' => 'Allow to update faq.',
            ],
            [
                'name' => 'Delete faq',
                'slug' => 'cms::faqs.delete',
                'description' => 'Allow to delete faq.',
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
