<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AlterBase\Models\Post\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->realText(rand(50,100));

        $description = $this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400));
        $description .= $this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400));

        return [
            'title' => $title,
            'slug' => strtolower(str_replace([" ", "_", "*", "'", '"', "@", "&"], "-",$title)."-".rand(11111,9999999)),
            'summary' => $this->faker->realText(200),
            'description' => $description,
            'image' => "https://picsum.photos/seed/".rand(1,10000)."/800/600",
            'author' => 1,
            'last_modified' => 1,
            'post_type' => 'post',
            'publish' => 1,
            'published_on' => "202".rand(1,2)."-".rand(10,12)."-".rand(10,29)." 10:00:00"
        ];
    }
}
