<?php

namespace App\AlterBase\Repositories\User;

use App\AlterBase\Repositories\Repository;

class EmailSubscriptionRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    function getModel()
    {
        return 'App\AlterBase\Models\User\EmailSubscription';
    }

    /**
     * Clear last subscriptions
     */
    public function truncateSubscription($id)
    {
        return $this->model->from('email_subscriptions')
            ->where('user_id', $id)
            ->delete();
    }
}