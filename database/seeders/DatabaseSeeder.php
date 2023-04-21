<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        // $this->call(PageTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(PostCategoryTableSeeder::class);
        // $this->call(PartnerTypeTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
    }
}
