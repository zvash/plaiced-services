<?php

namespace App\Models;

use App\Models\Abstraction\AssetProvider as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaAsset extends Model
{
    use SoftDeletes;

    /**
     * Get the parent assetable model (brand or content).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function assetable()
    {
        return $this->morphTo();
    }
}
