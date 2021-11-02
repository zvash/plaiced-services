<?php

namespace App\Models;

use App\Models\Pivots\UserWishlist;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes, HasUuid, Notifiable, HasRoles, HasApiTokens;

    /**
     * User statuses.
     *
     * @var int
     */
    public const
        STATUS_PENDING_VERIFICATION = 1,
        STATUS_PENDING_FIRST_LINE_ITEM = 2,
        STATUS_PENDING_APPROVAL = 3,
        STATUS_ACTIVE = 4,
        STATUS_INACTIVE = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'integer',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_PENDING_VERIFICATION,
    ];

    /**
     * Check user is superadmin or not.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->roles->contains->isSuperAdmin();
    }

    /**
     * Get the advertiser for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function advertiser()
    {
        return $this->hasOne(Advertiser::class);
    }

    /**
     * Get the content creator for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function contentCreator()
    {
        return $this->hasOne(ContentCreator::class);
    }

    /**
     * Get the community news for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communityNews()
    {
        return $this->hasMany(CommunityNews::class, 'author_id');
    }

    /**
     * Get the advertiser surveys for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertiserSurveys()
    {
        return $this->hasMany(AdvertiserSurvey::class);
    }

    /**
     * Get the content creator surveys for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contentCreatorSurveys()
    {
        return $this->hasMany(ContentCreatorSurvey::class);
    }

    /**
     * Get the posts for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the payments for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the follows for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    /**
     * Get the likes for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the wishlists for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class)
            ->using(UserWishlist::class)
            ->withTimestamps();
    }

    /**
     * Create a query builder to fetch a survey for specific deal.
     *
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function hasSurvey(Deal $deal)
    {
        $builder = $this->isAdvertiser()
            ? $this->contentCreatorSurveys()
            : $this->advertiserSurveys();

        return $builder->whereDealId($deal->id);
    }

    /**
     * Check user is an advertiser.
     *
     * @return bool
     */
    public function isAdvertiser()
    {
        return $this->class === Advertiser::class;
    }

    /**
     * Check user is a content creator.
     *
     * @return bool
     */
    public function isContentCreator()
    {
        return $this->class === ContentCreator::class;
    }

    /**
     * Check user liked specific model (content or brand).
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function liked(Model $model)
    {
        return $this->likes()
            ->whereHasMorph(
                'likable',
                get_class($model),
                fn (Builder $query) => $query->whereKey($model->id)
            )
            ->exists();
    }

    /**
     * Check user followed specific model (content creator or advertiser).
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function followed(Model $model)
    {
        return $this->follows()
            ->whereHasMorph(
                'followable',
                get_class($model),
                fn (Builder $query) => $query->whereKey($model->id)
            )
            ->exists();
    }
}
