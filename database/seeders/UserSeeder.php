<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Traits\HasSeeder;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use HasSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $user) {
            User::create($this->resolveAttributes($user));
        }
    }

    /**
     * Resolve array attributes.
     *
     * @param  array  $user
     * @return array
     */
    private function resolveAttributes(array $user)
    {
        return array_merge($user, [
            'email_verified_at' => now(),
            'status' => User::STATUS_ACTIVE,
            'password' => bcrypt($user['password']),
        ]);
    }
}
