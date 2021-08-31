<?php

namespace App\Http\Controllers\Api\DropdownGroups;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDropdownRequest;
use App\Http\Resources\DropdownResource;
use App\Models\Dropdown;
use App\Models\DropdownGroup;

class DropdownGroupController extends Controller
{
    /**
     * Dropdown group controller constructor.
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
     * @param  \App\Models\DropdownGroup  $dropdownGroup
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(DropdownGroup $dropdownGroup)
    {
        return DropdownResource::collection(
            $dropdownGroup->dropdowns()->orderBy('title')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDropdownRequest  $request
     * @param  \App\Models\DropdownGroup  $dropdownGroup
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDropdownRequest $request, DropdownGroup $dropdownGroup)
    {
        $dropdown = $dropdownGroup->dropdowns()->save(
            new Dropdown($request->validated())
        );

        $dropdown->update(['value' => $dropdown->id]);

        $resource = new DropdownResource($dropdown);

        return $resource->withLocation(
            'dropdown-groups.dropdowns.index', [$dropdownGroup]
        );
    }
}
