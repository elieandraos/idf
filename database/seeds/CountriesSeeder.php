<?php

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
            factory(\App\Models\Country::class)->create();
        }
    }
}
