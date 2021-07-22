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
}
