<?php

namespace App\Models\Traits;

use App\Models\Country;

trait HasCountry
{
    /**
     * Get the country that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
