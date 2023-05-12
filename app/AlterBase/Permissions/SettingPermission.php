<?php

namespace App\AlterBase\Permissions;

use App\AlterBase\StorePermissions;

class SettingPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Settings',
            'slug' => 'cms::settings',
            'description' => 'Settings',
            'icon_class' => 'fa-user-cog',
        ],
        'actions' => [
            [
                'name' => 'Site settings',
                'slug' => 'cms::settings.index',
                'description' => 'Allow to update site settings.',
                'view_on_sidebar' => true,
                'menu_name' => "Site Settings"
            ],
            [
                'name' => 'Stripe settings',
                'slug' => 'cms::settings.stripe',
                'description' => 'Allow to update stripe settings.',
                'view_on_sidebar' => true,
                'menu_name' => "Stripe Settings"
            ],
            [
                'name' => 'Home settings',
                'slug' => 'cms::settings.home',
                'description' => 'Allow to update home settings.',
                'view_on_sidebar' => true,
                'menu_name' => "Home Settings"
            ],
            [
                'name' => 'Update User Setting',
                'slug' => 'cms::settings.profile',
                'description' => 'Allow users to update user setting',
                'view_on_sidebar' => true,
                'menu_name' => "Update Profile",
            ],
            
        ],
    ];

    /**
     * Store permissions related to users module
     *
     */
    public function store()
    {
        return StorePermissions::add($this->permissions);
    }
}
