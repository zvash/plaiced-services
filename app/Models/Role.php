<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_superadmin' => 'boolean',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_superadmin' => false,
    ];

    /**
     * Check role is superadmin or not.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->is_superadmin;
    }
}
