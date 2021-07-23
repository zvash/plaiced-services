<?php

namespace App\Models;

use App\Models\Pivots\UserWishlist;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

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
     * Get the advertisers for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertisers()
    {
        return $this->hasMany(Advertiser::class);
    }

    /**
     * Get the content creators for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contentCreators()
    {
        return $this->hasMany(ContentCreator::class);
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
        return $this->hasMany(AdvertiserSurvey::class);
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
}
