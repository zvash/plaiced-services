<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Has UUID trait boot method.
     *
     * @return void
     */
    public static function bootHasUuid()
    {
        static::creating(fn (Model $model) => $model->uuid ??= Str::orderedUuid());
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
