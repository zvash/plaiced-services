<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Models\Content;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Content controller constructor.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $contents = Content::when($request->has('feature'),
            fn (Builder $query, bool $feature) => $query->whereFeatured($feature)
        )->latest()->paginate(15);

        return ContentSummaryResource::collection($contents);
    }

    /**
     * Display the specified resource listing.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Content $content)
    {
        return new ContentSummaryResource($content);
    }
}
