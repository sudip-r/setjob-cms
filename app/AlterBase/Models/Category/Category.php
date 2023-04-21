<?php

namespace App\AlterBase\Models\Category;

use Illuminate\Database\Eloquent\Model;
use App\AlterBase\Models\Post\Post;

class Category extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'category',
    'slug',
    'parent',
    'type',
    'icon_light',
    'icon_dark',
    'publish',
    'summary'
  ];

  /**
   * Category has parent
   */
  public function parent()
  {
    return $this->where('id', $this->parent)->first();
  }

  /**
   * Category has many sub category
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function subCategories()
  {
    $cat = $this;
    return cacheRemember('category_model_sub_category_' . $cat->id, 1000, function () use ($cat) {
      return $this->where('parent', $cat->id)->where('publish', true)->get();
    });
  }

  /**
   * Category belongs to many post_categories
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function posts()
  {
    return $this->belongsToMany(Post::class, 'post_categories', 'category_id', 'post_id');
  }
}
