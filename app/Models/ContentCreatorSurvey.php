<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentCreatorSurvey extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deal_content_creator_surveys';

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
        'plaiced_rating' => 'integer',
        'other_party_rating' => 'integer',
    ];
}