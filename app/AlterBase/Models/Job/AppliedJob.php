<?php

namespace App\AlterBase\Models\Job;

use Illuminate\Database\Eloquent\Model;

class AppliedJob extends Model
{
    protected $table = "applied_jobs";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'employer_id',
        'applied_date',
        'cover_letter',
        'cover',
        'job_id'
    ];
}
