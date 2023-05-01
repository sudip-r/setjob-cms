<?php

namespace App\Policies;

use App\AlterBase\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnerPolicy
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
     * Determine whether the user can view the partner.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasPermission('cms::partners.index');
    }

    /**
     * Determine whether the user can create partners.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('cms::partners.create');
    }

    /**
     * Determine whether the user can update the partner.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('cms::partners.update');
    }

    /**
     * Determine whether the user can delete the partner.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('cms::partners.delete');
    }
}