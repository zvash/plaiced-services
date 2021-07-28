<?php

namespace App\Models;

use App\Models\Pivots\ContentTalent;
use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'talents';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    /**
     * Get the contents for the talent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contents()
    {
        return $this->belongsToMany(Content::class)
            ->using(ContentTalent::class)
            ->withTimestamps()
            ->withPivot(['type']);
    }
}
