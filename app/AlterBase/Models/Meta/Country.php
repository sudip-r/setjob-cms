<?php

namespace App\AlterBase\Models\Meta;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * @var $table 
     */
    protected $table = 'countries';

    /**
     * Country has many states
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

    /**
     * Country has many cities
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }

}
