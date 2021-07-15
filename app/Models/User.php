<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, HasUuid;

    /**
     * Pending verification status.
     *
     * @var int
     */
    public const STATUS_PENDING_VERIFICATION = 1;

    /**
     * Pending first line item status.
     *
     * @var int
     */
    public const STATUS_PENDING_FIRST_LINE_ITEM = 2;

    /**
     * Pending approval status.
     *
     * @var int
     */
    public const STATUS_PENDING_APPROVAL = 3;

    /**
     * Active status.
     *
     * @var int
     */
    public const STATUS_ACTIVE = 4;

    /**
     * Inactive status.
     *
     * @var int
     */
    public const STATUS_INACTIVE = 5;

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
    ];

    /**
     * Check status is pending verification.
     *
     * @return bool
     */
    public function isPendingVerification()
    {
        return $this->status === self::STATUS_PENDING_VERIFICATION;
    }

    /**
     * Check status is pending first line item.
     *
     * @return bool
     */
    public function isPendingFirstLineItem()
    {
        return $this->status === self::STATUS_PENDING_FIRST_LINE_ITEM;
    }

    /**
     * Check status is pending approval.
     *
     * @return bool
     */
    public function isPendingApproval()
    {
        return $this->status === self::STATUS_PENDING_APPROVAL;
    }

    /**
     * Check status is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * Check status is inactive.
     *
     * @return bool
     */
    public function isInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }
}
