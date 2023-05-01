<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\AlterBase\Models\Job\Job;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app(Job::class)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Job::jobFactory()->count(130)->create();
    }
}
