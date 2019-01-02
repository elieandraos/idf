<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            factory(Country::class)->create();
        }
    }
}
