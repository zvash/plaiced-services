<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
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
        'placement' => 'integer',
        'locations' => 'collection',
        'demographic_age' => 'collection',
        'demographic_gender' => 'collection',
        'demographic_income' => 'collection',
        'demographic_marital_status' => 'collection',
        'demographic_type_of_families' => 'collection',
        'demographic_household_size' => 'collection',
        'demographic_race' => 'collection',
        'demographic_education' => 'collection',
        'demographic_geography' => 'collection',
        'demographic_psychographic' => 'collection',
    ];
}
