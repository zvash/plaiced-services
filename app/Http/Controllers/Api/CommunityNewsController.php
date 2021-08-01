<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommunityNewsResource;
use App\Models\CommunityNews;

class CommunityNewsController extends Controller
{
    /**
     * CommunityNews controller constructor.
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CommunityNewsResource::collection(
            CommunityNews::latest()->paginate(15)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CommunityNews  $communityNews
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(CommunityNews $communityNews)
    {
        return new CommunityNewsResource($communityNews);
    }
}
