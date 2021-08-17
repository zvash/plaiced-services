<?php

namespace Database\Seeders;

use App\Models\DropdownGroup;
use Database\Seeders\Traits\HasSeeder;
use Illuminate\Database\Seeder;

class DropdownGroupSeeder extends Seeder
{
    use HasSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $group) {
            DropdownGroup::create($group);
        }
    }
}
