<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\AlterBase\Models\Post\PostCategory;
use Illuminate\Support\Facades\DB;

class PostCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app(PostCategory::class)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        for($i = 1; $i <= 100; $i++)
        {
            $data = [
                'post_id' => $i,
                'category_id' => 8
                ];
      
            PostCategory::create($data); 
        }
    }
}
