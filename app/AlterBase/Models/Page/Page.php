<?php

namespace App\AlterBase\Models\Page;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page',
        'slug',
        'summary',
        'description',
        'type',
        'blocks',
        'image',
        'cover',
        'video',
        'publish'
    ];
}
