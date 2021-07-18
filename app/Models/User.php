<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes, HasUuid, Notifiable, HasRoles;

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
}
