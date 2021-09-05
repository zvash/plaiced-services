<?php

namespace App\Models;

use App\Models\Abstraction\AssetProvider as Model;

class MediaAsset extends Model
{
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
