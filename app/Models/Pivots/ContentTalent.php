<?php

namespace App\Models\Pivots;

use App\Models\Traits\HasDropdown;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContentTalent extends Pivot
{
    use HasDropdown;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Get the type that owns the content talent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->dropdown('type');
    }
}
