<?php

namespace App\AlterBase\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'category_id',
    ];

}
