<?php

namespace App\Models\Traits;

use App\Models\Dropdown;

trait HasDropdown
{
    /**
     * Get the field dropdown that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dropdown(string $field)
    {
        return $this->belongsTo(Dropdown::class, $field);
    }
}
