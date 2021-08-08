<?php

namespace Database\Seeders;

use App\Models\TimelineTemplate;
use Database\Seeders\Traits\HasSeeder;
use Illuminate\Database\Seeder;

class TimelineTemplateSeeder extends Seeder
{
    use HasSeeder;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->seeds() as $template) {
            TimelineTemplate::create($template);
        }
    }
}
