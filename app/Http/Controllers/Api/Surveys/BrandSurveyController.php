<?php

namespace App\Http\Controllers\Api\Surveys;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Models\AdvertiserSurvey;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

class BrandSurveyController extends Controller
{
    /**
     * Brand surveys controller constructor.
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
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Brand $brand)
    {
        $callback = fn (Builder $query) => $query->whereKey($brand->id);

        return SurveyResource::collection(
            AdvertiserSurvey::whereHas('deal.brand', $callback)
                ->latest()
                ->paginate(15)
        );
    }
}
