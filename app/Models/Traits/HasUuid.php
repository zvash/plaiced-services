<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
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
     * Find model by uuid.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  string  $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUuid(Builder $builder, string $uuid)
    {
        return $builder->whereUuid($uuid);
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
