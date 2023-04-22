<?php

namespace App\AlterBase\Models\Job;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'summary',
        'description',
        'salary_min',
        'salary_max',
        'insurance',
        'deadline',
        'location',
        'remote',
        'responsibilities',
        'required_skills',
        'preferred_skills',
        'type',
        'trash',
        'publish',
        'published_on',
    ];

    /**
     * Jobs have users
     *
     * @return Collection
     */
    public function user()
    {
        return $this->from('jobs as j')
            ->join('users as u', 'j.user_id', 'u.id')
            ->where('j.id', $this->id)
            ->select([
                'u.id',
                'u.name',
            ])
            ->get()
            ->first();
    }

    /**
     * Jobs have location
     *
     * @return Collection
     */
    public function city()
    {
        if ($this->location == "0") {
            return $this->from('jobs as j')
                ->join('user_profile as p', 'j.user_id', 'p.user_id')
                ->join('cities as c', 'c.id', 'p.city_id')
                ->where('j.id', $this->id)
                ->select([
                    'c.id',
                    'c.name',
                ])
                ->get()
                ->first();
        }

        return $this->from('jobs as j')
            ->join('cities as c', 'j.location', 'c.id')
            ->where('j.id', $this->id)
            ->select([
                'c.id',
                'c.name',
            ])
            ->get()
            ->first();
    }

}
