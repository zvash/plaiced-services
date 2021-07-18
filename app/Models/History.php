<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deal_histories';

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
        'changes' => 'collection',
        'original' => 'collection',
    ];

    /**
     * Set changes and original base on injected model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return $this
     */
    public function setChanges(Model $model)
    {
        if ($model->isClean()) {
            return $this;
        }

        $original = array_intersect_key($model->getOriginal(), $changes = $model->getDirty());

        return $this->fill(compact('original', 'changes'));
    }
}
