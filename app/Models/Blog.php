<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasUuid;

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
        'featured' => 'boolean',
        'tags' => 'collection',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'featured' => false,
    ];
}
