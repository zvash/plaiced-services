<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->purge()->call([
            TimelineTemplateSeeder::class,
            ClientSeeder::class,
            UserSeeder::class,
        ]);
    }

    /**
     * Purge all directories.
     *
     * @return $this
     */
    protected function purge()
    {
        Storage::disk('s3')->flushCache();

        foreach (Storage::disk('s3')->directories() as $directory) {
            Storage::disk('s3')->deleteDirectory($directory);
        }

        return $this;
    }
}
