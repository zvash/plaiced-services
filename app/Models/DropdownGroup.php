<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DropdownGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Get the dropdowns for the dropdown group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dropdowns()
    {
        return $this->hasMany(Dropdown::class, 'group_id');
    }

    /**
     * Get the trailing dropdowns for the dropdown group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trailingDropDowns()
    {
        return $this->hasMany(Dropdown::class, 'group_trailing_id');
    }
}
