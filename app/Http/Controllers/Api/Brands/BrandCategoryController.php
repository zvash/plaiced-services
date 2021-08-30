<?php

namespace App\Http\Controllers\Api\Brands;

use App\Http\Controllers\Controller;
use App\Http\Resources\DropdownResource;
use App\Models\Brand;
use App\Models\Dropdown;
use Illuminate\Database\Eloquent\Builder;

class BrandCategoryController extends Controller
{
    /**
     * Brand category controller constructor.
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
        $categories = Brand::select('category')
            ->whereHas('category', fn (Builder $builder) => $builder->whereCustom(false))
            ->distinct()
            ->pluck('category');

        return DropdownResource::collection(
            Dropdown::with('groupTrailing')
                ->WhereIn('id', $categories)
                ->get()
        );
    }
}
