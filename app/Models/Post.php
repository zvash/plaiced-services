<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes, HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deal_posts';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deal that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    /**
     * Get the post assets for the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asset()
    {
        return $this->hasMany(PostAsset::class, 'post_id');
    }

    /**
     * Get the timeline for the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function timeline()
    {
        return $this->morphOne(Timeline::class, 'model');
    }
}
