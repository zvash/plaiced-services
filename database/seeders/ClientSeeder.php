<?php

namespace Database\Seeders;

use App\Models\Client;
use Database\Seeders\Traits\HasSeeder;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    use HasSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $client) {
            Client::create($this->resolveAttributes($client));
        }
    }

    /**
     * Resolve array attributes.
     *
     * @param  array  $client
     * @return array
     */
    private function resolveAttributes(array $client)
    {
        return array_merge($client, [
            'redirect' => $client['redirect'] ? config($client['redirect']) : '',
        ]);
    }
}
