<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use SoftDeletes, HasUuid;

    /**
     * Coordinate added value statuses.
     *
     * @var int
     */
    public const
        COORDINATE_ADDED_VALUE_PENDING = 1,
        COORDINATE_ADDED_VALUE_ACCEPTED = 2,
        COORDINATE_ADDED_VALUE_REJECTED = 3;

    /**
     * Media accountability statuses.
     *
     * @var int
     */
    public const
        MEDIA_ACCOUNTABILITY_PENDING = 1,
        MEDIA_ACCOUNTABILITY_ACCEPTED = 2,
        MEDIA_ACCOUNTABILITY_REJECTED = 3;

    /**
     * Deal types.
     *
     * @var int
     */
    public const
        TYPE_BARTER = 1,
        TYPE_PAID = 2;

    /**
     * Ownership types.
     *
     * @var int
     */
    public const
        OWNERSHIP_TYPE_KEEP = 1,
        OWNERSHIP_TYPE_LOAN = 2;

    /**
     * Exposure expectations statuses.
     *
     * @var int
     */
    public const
        EXPOSURE_EXPECTATIONS_MANDATORY = 1,
        EXPOSURE_EXPECTATIONS_FLEXIBLE = 2;

    /**
     * Deal statuses.
     *
     * @var int
     */
    public const
        STATUS_PENDING = 1,
        STATUS_WAITING_FOR_PAYMENT = 2,
        STATUS_ACTIVE = 3,
        STATUS_FINISHED = 4,
        STATUS_REJECTED = 5,
        STATUS_RETRACTED = 6;

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
        'status' => 'integer',
        'is_public' => 'boolean',
        'ownership_type' => 'integer',
        'arrival_speed' => 'collection',
        'advertiser_gets' => 'collection',
        'when_needed' => 'datetime:Y-m-d',
        'media_accountability' => 'integer',
        'exposure_expectations' => 'integer',
        'coordinate_added_value' => 'integer',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_public' => true,
        'type' => self::TYPE_BARTER,
        'status' => self::STATUS_PENDING,
        'exposure_expectations' => self::EXPOSURE_EXPECTATIONS_MANDATORY,
    ];
}
