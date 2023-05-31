<?php

namespace App\AlterBase\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSubscription extends Model
{
    use HasFactory;

    /**
     * @var TableName
     */
    protected $table = "email_subscriptions";

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'category_id',
    'type'
  ];
}
