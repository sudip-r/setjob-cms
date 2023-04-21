<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\AlterBase\Models\Post\Post;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app(Post::class)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Post::postFactory()->count(1000)->create();
    }
}
