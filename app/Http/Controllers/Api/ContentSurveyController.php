<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyResource;
use App\Models\Content;
use App\Models\ContentCreatorSurvey;
use Illuminate\Database\Eloquent\Builder;

class ContentSurveyController extends Controller
{
    /**
     * Content surveys controller constructor.
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
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Content $content)
    {
        $callback = fn (Builder $query) => $query->whereKey($content->id);

        return SurveyResource::collection(
            ContentCreatorSurvey::whereHas('deal.content', $callback)
                ->latest()
                ->paginate(15)
        );
    }
}
