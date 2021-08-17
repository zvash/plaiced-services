<?php

namespace Database\Seeders;

use App\Models\Dropdown;
use Database\Seeders\Traits\HasSeeder;
use Illuminate\Database\Seeder;

class DropdownSeeder extends Seeder
{
    use HasSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $dropdown) {
            Dropdown::create($dropdown);
        }
    }
}
