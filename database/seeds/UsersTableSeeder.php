<?php

use App\UserLevel;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLevel::create([
            'name' => 'Admin',
        ]);
        UserLevel::create([
            'name' => 'Kasir',
        ]);

        User::create([
			'name' => 'Admin',
			'username' => 'admin',
			'password' => bcrypt('admin'),
			'user_level_id' => '1',
		]);
        User::create([
			'name' => 'Kasir',
			'username' => 'kasir',
			'password' => bcrypt('kasir'),
			'user_level_id' => '2',
		]);
    }
}
