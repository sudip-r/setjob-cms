<?php

namespace App\AlterBase\Models\Job;

use Illuminate\Database\Eloquent\Model;

class FavoriteJob extends Model
{
    protected $table = "favorite_jobs";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'job_id'
    ];
}