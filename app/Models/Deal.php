<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Get the country that owns the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the parent owner model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * Get the brand that owns the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the content that owns the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     *  Get the advertiser survey for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function advertiserSurvey()
    {
        return $this->hasOne(AdvertiserSurvey::class);
    }

    /**
     *  Get the content creator survey for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contentCreatorSurvey()
    {
        return $this->hasOne(ContentCreatorSurvey::class);
    }

    /**
     *  Get the histories for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }

    /**
     *  Get the posts for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     *  Get the products for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     *  Get the timelines for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }

    /**
     * Get the payment for the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get all the deals related to specific advertiser.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByAdvertiser(Builder $builder, Advertiser $advertiser)
    {
        return $builder->whereHas(
            'brand.advertiser',
            fn (Builder $query) => $query->whereKey($advertiser->id)
        );
    }

    /**
     * Get all the deals related to specific content creator.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByContentCreator(Builder $builder, ContentCreator $contentCreator)
    {
        return $builder->whereHas(
            'content.contentCreator',
            fn (Builder $query) => $query->whereKey($contentCreator->id)
        );
    }

    /**
     * Check authorization specific user for a deal.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function authorize(User $user)
    {
        $authorized = new Collection([
            $this->owner->user,
            $this->brand->advertiser->user,
            $this->content->contentCreator->user,
        ]);

        return $authorized->unique()->contains($user);
    }

    /**
     * Create template timeline for the deal.
     *
     * @param  string  $event
     * @param  array  $parameters
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\Timeline|false
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function addTimeline($event, array $parameters = [])
    {
        $timeline = new Timeline(compact('parameters'));

        $timeline->model()->associate(
            TimelineTemplate::event($event)->firstOrFail()
        );

        return $this->timelines()->save($timeline);
    }

    /**
     * Create post timeline for the deal.
     *
     * @param  \App\Models\Post  $post
     * @param  array  $parameters
     * @return \Illuminate\Database\Eloquent\Model|\App\Models\Timeline|false
     */
    public function addPostTimeline(Post $post, array $parameters = [])
    {
        $timeline = new Timeline(compact('parameters'));

        $timeline->model()->associate($post);

        return $this->timelines()->save($timeline);
    }

    /**
     * Get all the statuses.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_WAITING_FOR_PAYMENT,
            self::STATUS_ACTIVE,
            self::STATUS_FINISHED,
            self::STATUS_REJECTED,
            self::STATUS_RETRACTED
        ];
    }
}
