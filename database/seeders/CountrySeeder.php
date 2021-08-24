<?php

namespace Database\Seeders;

use App\Models\Country;
use Database\Seeders\Traits\HasSeeder;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    use HasSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $country) {
            Country::create($country);
        }
    }
}
