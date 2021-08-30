<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Http\Resources\DropdownResource;
use App\Models\Content;
use App\Models\Dropdown;
use Illuminate\Database\Eloquent\Builder;

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
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke()
    {
        $categories = Content::select('category')
            ->whereHas('category', fn (Builder $builder) => $builder->whereCustom(false))
            ->distinct()
            ->pluck('category');

        $dropdowns = Dropdown::with('groupTrailing')
            ->WhereIn('id', $categories)
            ->get();

        return DropdownResource::collection($dropdowns);
    }
}
