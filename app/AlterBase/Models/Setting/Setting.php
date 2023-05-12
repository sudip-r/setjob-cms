<?php

namespace App\AlterBase\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'trial_period',
        'facebook',
        'twitter',
        'linkedin',
        'youtube',
        'instagram',
        'tiktok'
    ];

}
