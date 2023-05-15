<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\AlterBase\Models\Setting\Setting;
use App\AlterBase\Models\Setting\Stripe;
use App\AlterBase\Models\Setting\HomeSetting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      app(Setting::class)->truncate();
      app(Stripe::class)->truncate();
      app(HomeSetting::class)->truncate();
      DB::statement('SET FOREIGN_KEY_CHECKS=1');

      $data = [
        'id' => 1,
        'trial_period' => '30',
        'facebook' => '',
        'twitter'  => '',
        'linkedin'  => ''
      ];
      Setting::create($data);  

      $data = [
        'id' => 1,
        'live' => 0,
        'subscription_fee' => 1
      ];
      Stripe::create($data);  

      $data = [
        'id' => 1,
        'title' => 'We are Set Jobs',
        'sub_title' => 'Find the perfect job for you',
        'left_col_title' => 'Post jobs for your next potential hire',
        'left_col_summary' => 'Fusce quis quam et enim porta elementum a eu augue. Nullam sit amet quam id justo congue vulputate at ut metus. Vestibulum lacinia tempor turpis, eget accumsan sem interdum id.',
        'left_col_btn' => 'POST A JOB',
        'left_col_btn_link' => '',
        'right_col_title' => 'Become a member for only £1 a month!',
        'right_col_summary' => 'Fusce quis quam et enim porta elementum a eu augue. Nullam sit amet quam id justo congue vulputate at ut metus. Vestibulum lacinia tempor turpis, eget accumsan sem interdum id.',
        'right_col_btn' => 'REGISTER NOW',
        'right_col_btn_link' => '',
        
      ];
      HomeSetting::create($data);  
    }
}
