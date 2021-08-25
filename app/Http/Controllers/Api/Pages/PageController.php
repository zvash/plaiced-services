<?php

namespace App\Http\Controllers\Api\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Page controller constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('client:*');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PageResource::collection(Page::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Page $page)
    {
        return new PageResource($page);
    }
}
