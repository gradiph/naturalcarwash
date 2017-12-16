<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(UsersTableSeeder::class);
    	$this->call(MechanicsTableSeeder::class);
    	$this->call(WashingRatesTableSeeder::class);
    	$this->call(ProductTypesTableSeeder::class);
    	$this->call(ExpenditureTypesTableSeeder::class);
    }
}
