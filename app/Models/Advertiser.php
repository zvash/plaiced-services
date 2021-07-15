<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertiser extends Model
{
    use SoftDeletes, HasUuid;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'float',
        'rating_count' => 'integer',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'rating_count' => 0,
    ];
}