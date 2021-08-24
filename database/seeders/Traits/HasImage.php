<?php

namespace Database\Seeders\Traits;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    /**
     * Create a random image and save it in disk.
     *
     * @param  string  $path
     * @param  Factory|null  $factory
     * @param  int  $width
     * @param  int  $height
     * @return bool
     */
    public function image(string $path, ?Generator $factory = null, $width = 256, $height = 256)
    {
        $factory ??= Factory::create();

        $image = $factory->image(null, $width, $height);

        return Storage::disk('s3')->put($path, new File($image));
    }
}
