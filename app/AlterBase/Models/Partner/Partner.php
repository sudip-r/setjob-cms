<?php

namespace App\AlterBase\Models\Partner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_name',
        'image',
        'cover_image',
        'partner_link',
        'sort_order',
        'summary',
        'description',
        'publish'
    ];
}
