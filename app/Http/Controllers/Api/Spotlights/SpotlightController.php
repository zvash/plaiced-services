<?php

namespace App\Http\Controllers\Api\Spotlights;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpotlightResource;
use App\Models\Spotlight;

class SpotlightController extends Controller
{
    /**
     * Spotlight controller constructor.
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
        return SpotlightResource::collection(
            Spotlight::whereActive(true)->latest()->get()
        );
    }
}
