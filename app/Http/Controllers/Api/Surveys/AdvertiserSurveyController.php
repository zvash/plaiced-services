<?php

namespace App\Http\Controllers\Api\Surveys;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Models\Advertiser;
use App\Models\AdvertiserSurvey;
use Illuminate\Database\Eloquent\Builder;

class AdvertiserSurveyController extends Controller
{
    /**
     * Advertiser surveys controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Advertiser  $advertiser
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Advertiser $advertiser)
    {
        $callback = fn (Builder $query) => $query->whereKey($advertiser->id);

        return SurveyResource::collection(
            AdvertiserSurvey::whereHas('deal.brand.advertiser', $callback)
                ->latest()
                ->paginate(15)
        );
    }
}
