<?php

namespace App\Providers;

use App\AlterBase\Models\Category\Category;
use App\AlterBase\Models\Media\Media;
use App\AlterBase\Models\Post\Post;
use App\AlterBase\Models\User\Role;
use App\AlterBase\Models\User\User;
use App\AlterBase\Models\Setting\Message;
use App\Policies\CategoryPolicy;
use App\Policies\MediaPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\SettingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      'App\Model' => 'App\Policies\ModelPolicy',
      User::class => UserPolicy::class,
      Role::class => RolePolicy::class,
      Message::class => SettingPolicy::class,
      Category::class => CategoryPolicy::class, 
      Media::class => MediaPolicy::class,
      Post::class => PostPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
