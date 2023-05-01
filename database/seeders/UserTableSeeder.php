<?php

namespace Database\Seeders;

use App\AlterBase\Models\User\User;
use App\AlterBase\Models\User\UserSetting;
use App\AlterBase\Models\User\Profile;
use App\AlterBase\Models\User\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        app(User::class)->truncate();
        app(UserSetting::class)->truncate();
        app(Role::class)->truncate();
        app(Profile::class)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            'id' => '1',
            'name' => "Webifi",
            'email' => "admin@webifi.co.uk",
            'slug' => 'webifi',
            'password' => "abc@!23XttS1",
            'verified' => 1,
            'active' => 1,
            'guard' => 'web',
            'user_type' => 'web',
        ];

        $user = User::create($data);

        $data = [
          'user_id' => $user->id,
          'dark_mode' => false
        ];

        UserSetting::create($data);

        $data = [
            'name' => 'Admin'
        ];

        Role::create($data);

        $data = [
            'id' => '2',
            'name' => "Test Business",
            'slug' => 'test-business',
            'email' => "test-business@webifi.co.uk",
            'password' => "abc@112",
            'verified' => 1,
            'active' => 1,
            'guard' => 'business',
            'user_type' => 'business',
        ];

        $user = User::create($data);

        $profile = Profile::create([
            'user_id' => "2",
            'city_id' => rand(48157, 50000),
            'name' => "Test Business"
        ]);

        $data = [
            'id' => '3',
            'name' => "Test Business 2",
            'slug' => 'test-business-2',
            'email' => "test-business2@webifi.co.uk",
            'password' => "abc@112",
            'verified' => 1,
            'active' => 1,
            'guard' => 'business',
            'user_type' => 'business',
        ];

        $user = User::create($data);

        $profile = Profile::create([
            'user_id' => "3",
            'name' => "Test Business 2",
            'city_id' => rand(48157, 50000)
        ]);
    }
}
