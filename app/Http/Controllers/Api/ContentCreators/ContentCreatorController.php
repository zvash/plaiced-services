<?php

namespace App\Http\Controllers\Api\ContentCreators;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexSortRequest;
use App\Http\Resources\Summaries\ContentCreatorSummaryResource;
use App\Models\ContentCreator;

class ContentCreatorController extends Controller
{
    /**
     * Content creator controller constructor.
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
     * @param  \App\Http\Requests\IndexSortRequest  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexSortRequest $request)
    {
        $attributes = $request->validated();

        return ContentCreatorSummaryResource::collection(
            ContentCreator::wherePrivate(false)
                ->orderBy($attributes['sort_by'], $attributes['sort_type'])
                ->paginate(15)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(ContentCreator $contentCreator)
    {
        return new ContentCreatorSummaryResource($contentCreator);
    }
}
