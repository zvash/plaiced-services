<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasUuid;

    /**
     * Social types.
     *
     * @var int
     */
    public const
        TYPE_WEBSITE = 1,
        TYPE_FACEBOOK = 2,
        TYPE_INSTAGRAM = 3,
        TYPE_TWITTER = 4,
        TYPE_LINKEDIN = 5;

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
        'type' => 'integer',
    ];

    /**
     * Get social type by name.
     *
     * @return string
     */
    public function getType()
    {
        switch ($this->type) {
            case self::TYPE_WEBSITE:
                return 'website';
            case self::TYPE_FACEBOOK:
                return 'facebook';
            case self::TYPE_INSTAGRAM:
                return 'instagram';
            case self::TYPE_TWITTER:
                return 'twitter';
            case self::TYPE_LINKEDIN:
                return 'linkedin';
            default:
                return 'unknown';
        }
    }

    /**
     * Get the parent sociable model (content, brand, content creator or advertiser).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function sociable()
    {
        return $this->morphTo();
    }
}
