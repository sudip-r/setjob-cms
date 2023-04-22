<?php

namespace App\AlterBase\Models\Meta;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * @var $table 
     */
    protected $table = 'cities';

    /**
     * City belongs to a country
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * City belongs to a state
     * 
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

}
