<?php

namespace App\AlterBase\Models\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
  protected $table  = 'user_profile';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'name',
    'address',
    'contact',
    'contact_person', // Used for CV for employee
    'mobile', //Used for website in this application
    'cover_image', 
    'description',
    'summary',
    'categories', //Portfolio for employee
    'map', //Used for employee qualification
    'city_id',
    'postal_code',
    'linkedin',
    'twitter',
    'facebook',
    'instagram'
  ];

  /**
     * Get city from profile
     *
     * @return Collection
     */
    public function city()
    {
        return $this->from('profile as p')
            ->join('cities as c', 'p.city_id', 'c.id')
            ->where('p.id', $this->city_id)
            ->select([
                'c.id',
                'c.name'
                ])
            ->get()
            ->first();
    }
}
