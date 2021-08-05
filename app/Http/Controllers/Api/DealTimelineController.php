<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TimelineResource;
use App\Models\Deal;
use App\Models\Timeline;

class DealTimelineController extends Controller
{
    /**
     * Deal timeline controller constructor.
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
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Deal $deal)
    {
        $this->authorize('viewAny', [$this, $deal]);

        return TimelineResource::collection(
            $deal->timelines()->latest()->paginate(20)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timeline  $timeline
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Timeline $timeline)
    {
        $this->authorize('view', [$this, $timeline->deal]);

        return new TimelineResource($timeline);
    }
}
