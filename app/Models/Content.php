<?php

namespace App\Models;

use App\Models\Pivots\ContentTalent;
use App\Models\Traits\HasDropdown;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
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
        'locations' => 'collection',
        'demographic_age' => 'collection',
        'demographic_gender' => 'collection',
        'demographic_geography_id' => 'collection',
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
     * Get the country that owns the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the content creator that owns the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contentCreator()
    {
        return $this->belongsTo(ContentCreator::class);
    }

    /**
     * Get the deals for the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    /**
     * Get the likes for the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Get the talents for the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function talents()
    {
        return $this->belongsToMany(Talent::class)
            ->using(ContentTalent::class)
            ->withTimestamps()
            ->withPivot(['type']);
    }

    /**
     * Get the payments for the content.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Deal::class);
    }
}
