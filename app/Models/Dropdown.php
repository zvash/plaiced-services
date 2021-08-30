<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dropdown extends Model
{
    use SoftDeletes;

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
        'custom' => 'boolean',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'custom' => false,
    ];

    /**
     * Get the group dropdown that owns the dropdown.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(DropdownGroup::class, 'group_id');
    }

    /**
     * Get the trailing group dropdown that owns the dropdown.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupTrailing()
    {
        return $this->belongsTo(DropdownGroup::class, 'group_trailing_id');
    }
}
