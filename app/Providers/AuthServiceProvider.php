<?php

namespace App\Providers;

use App\AlterBase\Models\Category\Category;
use App\AlterBase\Models\Faq\Faq;
use App\AlterBase\Models\Media\Media;
use App\AlterBase\Models\Post\Post;
use App\AlterBase\Models\User\Role;
use App\AlterBase\Models\User\User;
use App\AlterBase\Models\Setting\Message;
use App\AlterBase\Models\Job\Job;
use App\AlterBase\Models\Member\Member;
use App\AlterBase\Models\Partner\Partner;
use App\Policies\CategoryPolicy;
use App\Policies\FaqPolicy;
use App\Policies\MediaPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\SettingPolicy;
use App\Policies\JobPolicy;
use App\Policies\MemberPolicy;
use App\Policies\PartnerPolicy;
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
      Post::class => PostPolicy::class,
      Job::class => JobPolicy::class,
      Partner::class => PartnerPolicy::class,
      Faq::class => FaqPolicy::class,
      Member::class => MemberPolicy::class
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
