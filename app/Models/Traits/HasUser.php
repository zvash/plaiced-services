<?php

namespace App\Models\Traits;

use App\Models\User;

trait HasUser
{
    /**
     * Get the user that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
