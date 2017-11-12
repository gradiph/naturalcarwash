<?php

use Illuminate\Database\Seeder;
use App\WashingRate;

class WashingRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WashingRate::create([
			'name' => 'Salon',
			'price' => '100000',
		]);
        WashingRate::create([
			'name' => 'Mobil Biasa',
			'price' => '35000',
		]);
        WashingRate::create([
			'name' => 'Mobil Besar',
			'price' => '40000',
		]);
        WashingRate::create([
			'name' => 'Motor',
			'price' => '12000',
		]);
    }
}
