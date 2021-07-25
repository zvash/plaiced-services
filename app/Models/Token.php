<?php

namespace App\Models;

use Laravel\Passport\Token as Model;

class Token extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
        'created_at',
        'updated_at',
    ];
}
