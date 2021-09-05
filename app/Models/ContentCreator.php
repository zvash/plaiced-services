<?php

namespace App\Models;

use App\Models\Traits\HasDropdown;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentCreator extends Model
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
        'private' => 'boolean',
        'rating' => 'float',
        'rating_count' => 'integer',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'private' => false,
        'rating_count' => 0,
    ];

    /**
     * Get the country that owns the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user that owns the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contents for the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Get the deals for the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function deals()
    {
        return $this->morphMany(Deal::class, 'owner');
    }

    /**
     * Get the followers for the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    /**
     * Get the socials for the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function socials()
    {
        return $this->morphMany(Social::class, 'sociable');
    }

    /**
     * Get the type that owns the content creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->dropdown('type');
    }
}
