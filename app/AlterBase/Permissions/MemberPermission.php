<?php

namespace App\AlterBase\Permissions;


use App\AlterBase\StorePermissions;

class MemberPermission
{
    protected $permissions = [
        'module' => [
            'name' => 'Members',
            'slug' => 'cms::members',
            'description' => 'Members Management',
            'icon_class' => 'fas fa-user-friends'
        ],
        'actions' => [
            [
                'name' => 'View all employee',
                'slug' => 'cms::members.employee',
                'description' => 'Allow to view all employees.',
                'view_on_sidebar' => true,
                'menu_name' => "All Employees"
            ],
            [
                'name' => 'View all employers',
                'slug' => 'cms::members.employer',
                'description' => 'Allow to view all employers.',
                'view_on_sidebar' => true,
                'menu_name' => "All Employers"
            ]
        ]
    ];

    /**
     * Store permissions related to members module
     *
     */
    public function store()
    {
        return StorePermissions::add($this->permissions);
    }
}