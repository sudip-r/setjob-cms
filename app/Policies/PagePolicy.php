<?php

namespace App\Policies;

use App\AlterBase\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
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
     * Determine whether the user can view the page.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasPermission('cms::pages.index');
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('cms::pages.create');
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('cms::pages.update');
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('cms::pages.delete');
    }
}