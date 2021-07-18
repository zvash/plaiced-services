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
}
