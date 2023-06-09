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
        'flexible_date' => 'boolean',
        'ownership_type' => 'integer',
        'arrival_speed' => 'collection',
        'advertiser_gets' => 'collection',
        'media_accountability' => 'integer',
        'exposure_expectations' => 'integer',
        'coordinate_added_value' => 'integer',
        'shipping_submitted_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_public' => true,
        'flexible_date' => false,
        'type' => self::TYPE_BARTER,
        'status' => self::STATUS_PENDING,
        'ownership_type' => self::OWNERSHIP_TYPE_KEEP,
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
     * Get the submitter that owns the deal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'shipping_submitted_by');
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
     * Get all the deals for specific user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser(Builder $builder, User $user)
    {
        if ($user->isAdvertiser()) {
            return $builder->byAdvertiser($user->advertiser);
        }

        return $builder->byContentCreator($user->contentCreator);
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
     * Find changes and original.
     *
     * @return array
     */
    public function findChanges()
    {
        if ($this->isClean()) {
            return [];
        }

        $this->mergeCasts([
            'synopsis' => 'string',
            'viewership_metrics' => 'string',
            'content_creator_gets' => 'string',
            'advertiser_benefits' => 'string',
            'arrival_speed_brief' => 'string',
        ]);

        $changes = collect($this->getDirty())
            ->map(fn ($value, $key) => $this->castAttribute($key, $value))
            ->all();

        $original = array_intersect_key($this->getOriginal(), $changes);

        return compact('original', 'changes');
    }

    /**
     * Change coordinate added value status on deal.
     *
     * @return $this
     */
    public function contentCoordination(?int $status)
    {
        return tap($this->fill(['coordinate_added_value' => $status]))->save();
    }

    /**
     * Change media accountability status on deal.
     *
     * @return $this
     */
    public function mediaAccountability(?int $status)
    {
        return tap($this->fill(['media_accountability' => $status]))->save();
    }

    /**
     * Check deal is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Change deal status to pending.
     *
     * @return $this
     */
    public function pending()
    {
        return tap($this->fill(['status' => self::STATUS_PENDING]))->save();
    }

    /**
     * Check deal is waiting for payment.
     *
     * @return bool
     */
    public function isWatingForPayment()
    {
        return $this->status === self::STATUS_WAITING_FOR_PAYMENT;
    }

    /**
     * Change deal status to waiting for payment.
     *
     * @return $this
     */
    public function waitingForPayment()
    {
        return tap($this->fill(['status' => self::STATUS_WAITING_FOR_PAYMENT]))->save();
    }

    /**
     * Check deal is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Change deal status to active.
     *
     * @return $this
     */
    public function active()
    {
        return tap($this->fill(['status' => self::STATUS_ACTIVE]))->save();
    }

    /**
     * Check deal is finished.
     *
     * @return bool
     */
    public function isFinished()
    {
        return $this->status === self::STATUS_FINISHED;
    }

    /**
     * Change deal status to finished.
     *
     * @return $this
     */
    public function finished()
    {
        return tap($this->fill(['status' => self::STATUS_FINISHED]))->save();
    }

    /**
     * Check deal is rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * Change deal status to rejected.
     *
     * @return $this
     */
    public function rejected()
    {
        return tap($this->fill(['status' => self::STATUS_REJECTED]))->save();
    }

    /**
     * Check deal is retracted.
     *
     * @return bool
     */
    public function isRetracted()
    {
        return $this->status === self::STATUS_RETRACTED;
    }

    /**
     * Change deal status to retracted.
     *
     * @return $this
     */
    public function retracted()
    {
        return tap($this->fill(['status' => self::STATUS_RETRACTED]))->save();
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
