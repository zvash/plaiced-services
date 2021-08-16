<?php

namespace App\Models;

use App\Models\Abstraction\SurveyProvider as Model;

class AdvertiserSurvey extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deal_advertiser_surveys';
}
