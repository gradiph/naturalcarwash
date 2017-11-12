<?php

use Illuminate\Database\Seeder;
use App\Mechanic;

class MechanicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mechanic::create([
			'name' => 'Heri',
		]);
        Mechanic::create([
			'name' => 'Wahyu',
		]);
        Mechanic::create([
			'name' => 'Teddy',
		]);
    }
}
