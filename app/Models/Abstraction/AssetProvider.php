<?php

namespace App\Models\Abstraction;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class AssetProvider extends Model
{
    use HasUuid;

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
        'size' => 'integer',
    ];
}
