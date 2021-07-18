<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
        'numeric_code' => 'integer',
    ];

    /**
     * Get the advertisers for the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertisers()
    {
        return $this->hasMany(Advertiser::class);
    }

    /**
     * Get the content creators for the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contentCreators()
    {
        return $this->hasMany(ContentCreator::class);
    }

    /**
     * Get the contents for the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
