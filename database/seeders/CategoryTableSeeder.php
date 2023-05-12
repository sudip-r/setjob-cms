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
            'category' => "Scenic Carpenter",
            'slug' => "scenic-carpenter",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 2,
            'category' => "Scenic Artist",
            'slug' => "scenic-artist",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 3,
            'category' => "Metal Fabricator",
            'slug' => "metal-fabricator",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 4,
            'category' => "Prop maker",
            'slug' => "prop-maker",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 5,
            'category' => "Scenic Draughtsman",
            'slug' => "scenic-draughtsman",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 6,
            'category' => "Van Driver",
            'slug' => "van-driver",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 7,
            'category' => "Labourer",
            'slug' => "labourer",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Jobs",
        ];

        Category::create($data);

        $data = [
            'id' => 8,
            'category' => "News",
            'slug' => "news",
            'parent' => "0",
            'publish' => 1,
            'summary' => "",
            'type' => "Category",
        ];

        Category::create($data);

    }
}
