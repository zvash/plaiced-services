<?php

namespace Database\Seeders;

use App\Models\ContentCreator;
use Database\Seeders\Traits\HasImage;
use Database\Seeders\Traits\HasSeeder;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContentCreatorSeeder extends Seeder
{
    use HasSeeder, HasImage;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $contentCreator) {
            ContentCreator::create($this->resolveAttributes($contentCreator));
        }
    }

    /**
     * Resolve array attributes.
     *
     * @param  array  $contentCreator
     * @return array
     */
    private function resolveAttributes(array $contentCreator)
    {
        $faker = Factory::create();

        return array_merge($contentCreator, [
            'small_description' => $faker->text(),
            'description' => $faker->paragraph(),
            'telephone' => $faker->e164PhoneNumber(),
            'alt_telephone' => $faker->e164PhoneNumber(),
            'address' => $faker->address(),
            'city' => $faker->city(),
            'state' => $faker->state(),
            'postal_code' => $faker->postcode(),
            'avatar' => $this->image('content-creators', $faker),
        ]);
    }
}
