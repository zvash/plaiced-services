<?php

namespace Database\Seeders\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

trait HasSeeder
{
    /**
     * Read a file from stubs folder.
     *
     * @param string $path
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function read(string $path)
    {
        $file = database_path('seeders'.DIRECTORY_SEPARATOR.'Seeds'.DIRECTORY_SEPARATOR.$path);

        throw_unless(file_exists($file), FileNotFoundException::class);

        return file_get_contents($file);
    }

    /**
     * Read a file from stubs folder as decoded json.
     *
     * @param string $path
     * @param bool $assoc
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function readAsJson(string $path, bool $assoc = true)
    {
        return json_decode($this->read($path), $assoc);
    }

    /**
     * Read a seed file from stubs folder base on seeder class.
     *
     * @param bool $assoc
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function seeds(bool $assoc = true)
    {
        return $this->readAsJson($this->getSeedsFile(), $assoc);
    }

    /**
     * Get seed filename for specific seeder class.
     *
     * @param string|null $class
     * @return string
     */
    protected function getSeedsFile(?string $class = null)
    {
        $class ??= get_class($this);

        return Str::of($class)
            ->classBasename()
            ->beforeLast('Seeder')
            ->kebab()
            ->finish('.json');
    }
}
