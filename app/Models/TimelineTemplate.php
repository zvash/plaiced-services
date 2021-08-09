<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TimelineTemplate extends Model
{
    use HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deal_timeline_templates';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Get the timelines for the timeline template.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function timelines()
    {
        return $this->morphMany(Timeline::class, 'model');
    }

    /**
     * Find timeline template base on event name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEvent(Builder $builder, string $name)
    {
        return $builder->whereEventName($name);
    }
}
