<?php

use Illuminate\Database\Seeder;
use App\ExpenditureType;

class ExpenditureTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExpenditureType::create([
			'name' => '',
		]);
    }
}
