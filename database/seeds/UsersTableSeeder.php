<?php

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
        User::create([
			'name' => 'Admin',
			'username' => 'admin',
			'password' => bcrypt('admin'),
			'level' => 'Admin',
		]);
        User::create([
			'name' => 'Kasir',
			'username' => 'kasir',
			'password' => bcrypt('kasir'),
			'level' => 'Kasir',
		]);
    }
}
