<?php

namespace Database\Seeders;

use App\Models\Brand;
use Database\Seeders\Traits\HasImage;
use Database\Seeders\Traits\HasSeeder;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    use HasSeeder, HasImage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $brand) {
            Brand::create($this->resolveAttributes($brand));
        }
    }

    /**
     * Resolve array attributes.
     *
     * @param  array  $brand
     * @return array
     */
    private function resolveAttributes(array $brand)
    {
        $faker = Factory::create();

        return array_merge($brand, [
            'featured' => $faker->boolean(),
            'general_comment' => $faker->paragraph(),
            'locations' => $faker->words(3),
            'demographic_age' => $faker->words(3),
            'demographic_gender' => $faker->words(3),
            'demographic_income' => $faker->words(3),
            'demographic_marital_status' => $faker->words(3),
            'demographic_type_of_families' => $faker->words(3),
            'demographic_household_size' => $faker->words(3),
            'demographic_race' => $faker->words(3),
            'demographic_education' => $faker->words(3),
            'demographic_geography' => $faker->words(3),
            'demographic_psychographic' => $faker->words(3),
            'avatar' => $this->image('brands', $faker),
        ]);
    }
}
