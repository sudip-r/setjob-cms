<?php

namespace App\Policies;

use App\AlterBase\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    /**
     * Filter authorization before checking permissions
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->isSuperuser()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param User $user
     * @return bool
     */
    public function employee(User $user)
    {
        return $user->hasPermission('cms::members.employee');
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param User $user
     * @return bool
     */
    public function employer(User $user)
    {
        return $user->hasPermission('cms::members.employer');
    }

    
}
