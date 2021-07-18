<?php

namespace App\Models;

use App\Models\Abstraction\AssetProvider as Model;

class PostAsset extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deal_post_assets';

    /**
     * Get the post that owns the post asset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
