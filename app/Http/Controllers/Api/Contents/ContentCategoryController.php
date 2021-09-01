<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Http\Resources\DropdownResource;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Models\Content;
use App\Models\Dropdown;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContentCategoryController extends Controller
{
    /**
     * Content category controller constructor.
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
        $categories = Content::select('category')
            ->whereHas('category', fn (Builder $builder) => $builder->whereCustom(false))
            ->distinct()
            ->pluck('category');

        return DropdownResource::collection(
            Dropdown::with('groupTrailing')
                ->WhereIn('id', $categories)
                ->get()
        );
    }

    /**
     * Display the specified resource listing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dropdown  $dropdown
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Request $request, Dropdown $dropdown)
    {
        $limit = (int) $request->get('limit') ?: 5;

        return ContentSummaryResource::collection(
            Content::whereCategory($dropdown->id)
                ->take($limit <= 30 ? $limit : 5)
                ->get()
        );
    }
}
