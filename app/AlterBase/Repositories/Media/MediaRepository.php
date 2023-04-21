<?php

namespace App\AlterBase\Repositories\Media;

use App\AlterBase\Repositories\Repository;

class MediaRepository extends Repository
{

    /**
     * Get model name with namespace
     *
     * @return String
     */
    function getModel()
    {
        return 'App\AlterBase\Models\Media\Media';
    }
}