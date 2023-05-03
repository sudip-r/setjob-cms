<?php

namespace App\Policies;

use App\AlterBase\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FaqPolicy
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
     * Determine whether the user can view the faq.
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasPermission('cms::faqs.index');
    }

    /**
     * Determine whether the user can create faqs.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('cms::faqs.create');
    }

    /**
     * Determine whether the user can update the faq.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('cms::faqs.update');
    }

    /**
     * Determine whether the user can delete the faq.
     *
     * @param  \App\AlterBase\Models\User\User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('cms::faqs.delete');
    }
}