<?php

namespace App\Http\Controllers\Api\Surveys;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Models\ContentCreator;
use App\Models\ContentCreatorSurvey;
use Illuminate\Database\Eloquent\Builder;

class ContentCreatorSurveyController extends Controller
{
    /**
     * Content creator surveys controller constructor.
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
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ContentCreator $contentCreator)
    {
        $callback = fn (Builder $query) => $query->whereKey($contentCreator->id);

        return SurveyResource::collection(
            ContentCreatorSurvey::whereHas('deal.content.contentCreator', $callback)
                ->latest()
                ->paginate(15)
        );
    }
}
