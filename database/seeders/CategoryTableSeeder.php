<?php

namespace Database\Seeders;

use App\AlterBase\Models\Category\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app(Category::class)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            'id' => 1,
            'category' => "Jobs",
            'slug' => "jobs",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 2,
            'category' => "Full time",
            'slug' => "full-time",
            'parent' => "1",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 3,
            'category' => "Part time",
            'slug' => "part-time",
            'parent' => "1",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 4,
            'category' => "Freelance",
            'slug' => "freelance",
            'parent' => "1",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 5,
            'category' => "Contract",
            'slug' => "contract",
            'parent' => "1",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 6,
            'category' => "News and Updates",
            'slug' => "news-and-updates",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 7,
            'category' => "News",
            'slug' => "news",
            'parent' => "6",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

        $data = [
            'id' => 8,
            'category' => "Announcements",
            'slug' => "announcements",
            'parent' => "6",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);
    }
}
