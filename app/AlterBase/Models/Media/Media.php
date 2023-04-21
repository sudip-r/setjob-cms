<?php

namespace App\AlterBase\Models\Media;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'file_name',
    'url',
    'size',
    'resolution',
    'thumbnails'
  ];

}
