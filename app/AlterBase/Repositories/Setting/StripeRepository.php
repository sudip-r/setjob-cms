<?php

namespace App\AlterBase\Repositories\Setting;

use App\AlterBase\Repositories\Repository;

class StripeRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    function getModel()
    {
        return 'App\AlterBase\Models\Setting\Stripe';
    }
}