<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineTemplate extends Model
{
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
}
