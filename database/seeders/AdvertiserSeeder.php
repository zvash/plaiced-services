<?php

namespace Database\Seeders;

use App\Models\Advertiser;
use Database\Seeders\Traits\HasImage;
use Database\Seeders\Traits\HasSeeder;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AdvertiserSeeder extends Seeder
{
    use HasSeeder, HasImage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $advertiser) {
            Advertiser::create($this->resolveAttributes($advertiser));
        }
    }

    /**
     * Resolve array attributes.
     *
     * @param  array  $advertiser
     * @return array
     */
    private function resolveAttributes(array $advertiser)
    {
        $faker = Factory::create();

        return array_merge($advertiser, [
            'small_description' => $faker->text(),
            'description' => $faker->paragraph(),
            'telephone' => $faker->e164PhoneNumber(),
            'alt_telephone' => $faker->e164PhoneNumber(),
            'address' => $faker->address(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'postal_code' => $faker->postcode(),
            'avatar' => $this->image('advertisers', $faker),
        ]);
    }
}
