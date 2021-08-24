<?php

namespace Database\Seeders;

use App\Models\Content;
use Database\Seeders\Traits\HasImage;
use Database\Seeders\Traits\HasSeeder;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    use HasSeeder, HasImage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $content) {
            Content::create($this->resolveAttributes($content));
        }
    }

    /**
     * Resolve array attributes.
     *
     * @param  array  $content
     * @return array
     */
    private function resolveAttributes(array $content)
    {
        $faker = Factory::create();

        return array_merge($content, [
            'featured' => $faker->boolean(),
            'synopsis' => $faker->paragraph(),
            'viewership_metrics' => $faker->paragraph(),
            'general_comment' => $faker->paragraph(),
            'shipping_contact_name' => $faker->name(),
            'shipping_contact_telephone' => $faker->e164PhoneNumber(),
            'address' => $faker->address(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'postal_code' => $faker->postcode(),
            'locations' => $faker->words(3),
            'demographic_age' => $faker->words(3),
            'demographic_gender' => $faker->words(3),
            'demographic_geography_id' => $faker->words(3),
            'avatar' => $this->image('contents', $faker),
        ]);
    }
}
