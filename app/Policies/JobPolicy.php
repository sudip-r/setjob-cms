<?php

namespace App\Policies;

use App\AlterBase\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
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
     * Determine whether the user can view the jobs.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasPermission('cms::jobs.index');
    }

    /**
     * Determine whether the user can create jobs.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('cms::jobs.create');
    }

    /**
     * Determine whether the user can update the jobs.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('cms::jobs.update');
    }

    /**
     * Determine whether the user can delete the jobs.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('cms::jobs.delete');
    }

    /**
     * Determine whether the user can publish the jobs.
     *
     * @param User $user
     * @return bool
     */
    public function status(User $user)
    {
        return $user->hasPermission('cms::jobs.status');
    }

}
