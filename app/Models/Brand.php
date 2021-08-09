<?php

namespace App\Models;

use App\Models\Traits\HasDropdown;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes, HasUuid, HasDropdown;

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

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'featured' => false,
    ];

    /**
     * Get the advertiser that owns the brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    /**
     * Get the deals for the brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    /**
     * Get the likes for the brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Get the payments for the brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Deal::class);
    }
}
