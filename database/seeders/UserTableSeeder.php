<?php

namespace Database\Seeders;

use App\AlterBase\Models\User\User;
use App\AlterBase\Models\User\UserSetting;
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
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $data = [
            'name' => "Webifi",
            'email' => "admin@webifi.co.uk",
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
    }
}
