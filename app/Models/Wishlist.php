<?php

namespace App\Models;

use App\Models\Pivots\UserWishlist;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
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
        'similar' => 'collection',
    ];

    /**
     * Get the users for the wishlist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(UserWishlist::class)
            ->withTimestamps();
    }
}
