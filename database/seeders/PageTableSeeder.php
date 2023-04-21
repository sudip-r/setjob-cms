<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\alterBase\Models\Page\Page;
use Illuminate\Support\Facades\DB;


class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app(Page::class)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            'id' => 1,
            'page' => "About",
            'slug' => strtolower(str_replace(" ", "-","About")),
            'summary' => "",
            'description' => "",
            'publish' => 1,

        ];

        Page::create($data);

        $data = [
            'id' => 2,
            'page' => "Terms and Conditions",
            'slug' =>strtolower(str_replace(" ", "-","Terms and Conditions")),
            'summary' => "",
            'description' => "",
            'publish' => 1,

        ];

        Page::create($data);

        $data = [
            'id' => 3,
            'page' => "Privacy Policies",
            'slug' =>strtolower(str_replace(" ", "-","Privacy Policies")),
            'summary' => "",
            'description' => "",
            'publish' => 1,

        ];

        Page::create($data);

    }
}
