<?php

namespace App\AlterBase\Models\Meta;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * @var $table 
     */
    protected $table = 'states';

    /**
     * State belongs to country
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * State has many cities
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'id');
    }

}
