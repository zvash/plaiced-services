<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Models\ContentCreator;

class ContentCreatorContentController extends Controller
{
    /**
     * Content creator content controller constructor.
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
        return ContentSummaryResource::collection(
            $contentCreator->contents()->latest()->paginate(15)
        );
    }
}
