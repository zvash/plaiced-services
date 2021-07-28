<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;

class SectionController extends Controller
{
    /**
     * PageController constructor.
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
        return SectionResource::collection(Section::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Section $section)
    {
        return new SectionResource($section);
    }
}
