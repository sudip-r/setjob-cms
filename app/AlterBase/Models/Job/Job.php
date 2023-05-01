<?php

namespace App\AlterBase\Models\Job;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\JobFactory;

class Job extends Model
{
     /**
     * Has Factory
     */
    use HasFactory;

    /**
     * @return JobFactory
     *
     */
    protected static function jobFactory()
    {
        return JobFactory::new ();
    }
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
        'category_id',
        'trash',
        'publish',
        'published_on',
    ];

   /**
   * 
   */
  protected $appends = [
    'user_name',
    'user_slug',
    'published_date',
    'location_name',
    'salary_min_formatted',
    'salary_max_formatted',
    'category_name'
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

    /**
     * Get user name
     * 
     * @return String
     */
    public function getUserNameAttribute()
    {
        return getUserName($this->user_id);
    }

    /**
     * Get user slug
     * 
     * @return String
     */
    public function getUserSlugAttribute()
    {
        return getUserSlug($this->user_id);
    }

    /**
     * Get formatted published date
     * 
     * @return String
     */
    public function getPublishedDateAttribute()
    {
        return date("M d, Y", strtotime($this->published_on));
    }

     /**
     * Get formatted published date
     * 
     * @return String
     */
    public function getLocationNameAttribute()
    {
        return $this->city()->name;
    }

    /**
     * Get formatted salary
     * 
     * @return String
     */
    public function getSalaryMinFormattedAttribute()
    {
        return number_format($this->salary_min, 0);;
    }

    /**
     * Get formatted salary
     * 
     * @return String
     */
    public function getSalaryMaxFormattedAttribute()
    {
        return number_format($this->salary_max, 0);;
    }

    /**
     * Get category
     * 
     * @return Collection
     */
    public function Cat()
    {
        return $this->from('jobs as j')
            ->join('categories as c', 'c.id', 'j.category_id')
            ->where('j.id', $this->id)
            ->select(['c.id', 'c.category as name'])
            ->get()
            ->first();
    }

    /**
     * Get category name
     * 
     * @return String
     */
    public function getCategoryNameAttribute()
    {
        return $this->from('jobs as j')
            ->join('categories as c', 'c.id', 'j.category_id')
            ->where('j.id', $this->id)
            ->select(['c.id', 'c.category as name'])
            ->get()
            ->first()
            ->name;
    }
}
