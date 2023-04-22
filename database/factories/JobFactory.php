<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AlterBase\Models\Job\Job;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

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

        $type = ['Full time', 'Part time', 'Freelance', 'Contract'];
        return [
            'title' => $title,
            'user_id' => rand(2,3),
            'slug' => strtolower(str_replace([" ", "_", "*", "'", '"', "@", "&"], "-",$title)."-".rand(11111,9999999)),
            'summary' => $this->faker->realText(200),
            'description' => $description,
            'salary_min' => rand(1,200) * 1000,
            'salary_max' => rand(201,270) * 1000 * rand(0,1),
            'location' => rand(48157, 50000),
            'responsibilities' =>  $this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400)),
            'required_skills' =>  $this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400)),
            'publish' => 1,
            'trash' => 0,
            'type' => $type[array_rand($type)],
            'published_on' => "202".rand(2,3)."-".rand(10,12)."-".rand(10,29)." 10:00:00"
        ];
    }
}
