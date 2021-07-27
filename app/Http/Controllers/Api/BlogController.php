<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * BlogController constructor.
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
        return BlogResource::collection(Blog::latest('featured')->latest()->paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }
}
