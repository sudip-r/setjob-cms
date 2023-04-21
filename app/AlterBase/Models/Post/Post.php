<?php

namespace App\AlterBase\Models\Post;

use App\AlterBase\Models\Category\Category;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Has Factory
     */
    use HasFactory;

    /**
     * @return PostFactory
     *
     */
    protected static function postFactory()
    {
        return PostFactory::new ();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'image',
        'video',
        'author',
        'last_modified',
        'post_type',
        'trash',
        'publish',
        'published_on',
    ];

    /**
     * Post belongs to manu post_categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cats()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id')->orderBy('id', 'DESC');
    }

    /**
     * Post has many categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class, "post_id", "id");
    }

    /**
     * Get Post Thumb Image
     *
     * @param $thumbSize
     * @return String
     */
    public function thumbnail($thumbSize = "64X64")
    {
        if(str_contains($this->image, "picsum"))
            return str_replace("800/600","64", $this->image);

        $thumb = basename($this->image);

        return str_replace($thumb, $thumbSize . "_" . $thumb, $this->image);
    }

}
