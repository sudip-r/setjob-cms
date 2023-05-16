<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\AlterBase\Models\Job\Job;
use App\AlterBase\Models\Meta\City;

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

        $location = rand(48157, 50000);
        $location_text = $this->getCityById($location);
        $type = ['Workshop', 'On Site', 'Abroad', 'Various'];
        $salary_type = ['Per Hour', 'Per Annum', 'Freelance'];
        return [
            'title' => $title,
            'user_id' => rand(2,3),
            'slug' => strtolower(str_replace([" ", "_", "*", "'", '"', "@", "&"], "-",$title)."-".rand(11111,9999999)),
            'summary' => $this->faker->realText(200),
            'description' => $description,
            'salary_min' => rand(1,200) * 1000,
            'salary_max' => rand(201,270) * 1000 * rand(0,1),
            'location' => $location,
            'location_text' => $location_text,
            'responsibilities' =>  $this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400)),
            'required_skills' =>  $this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400))."<br><br>".$this->faker->realText(rand(120,400)),
            'publish' => 1,
            'trash' => 0,
            'category_id' => rand(1,7),
            'type' => $type[array_rand($type)],
            'salary_type' => $salary_type[array_rand($salary_type)],
            'published_on' => "202".rand(2,3)."-".rand(10,12)."-".rand(10,29)." 10:00:00"
        ];
    }

    /**
     * Get City name by ID
     * 
     * @param $location
     * @return String
     */
    private function getCityById($location)
    {
        $city = new City();

        return $city->find($location)->name;
    }
}
