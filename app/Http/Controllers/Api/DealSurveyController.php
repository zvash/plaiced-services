<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SurveyRepository as Repository;
use App\Http\Requests\StoreDealSurveyRequest;
use App\Http\Resources\SurveyResource;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealSurveyController extends Controller
{
    /**
     * Survey repository.
     *
     * @var \App\Http\Repositories\SurveyRepository
     */
    protected $repository;

    /**
     * Deal survey controller constructor.
     *
     * @param  \App\Http\Repositories\SurveyRepository  $repository
     * @return void
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth:api');

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \App\Exceptions\UserException
     */
    public function index(Request $request, Deal $deal)
    {
        return SurveyResource::collection(
            $request->user()->hasSurvey($deal)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreDealSurveyRequest  $request
     * @param  \App\Models\Deal  $deal
     * @return \Illuminate\Http\Resources\Json\JsonResource
     *
     * @throws \App\Exceptions\UserException
     */
    public function store(StoreDealSurveyRequest $request, Deal $deal)
    {
        $this->authorize('create', [$this, $deal]);

        $resource = new SurveyResource(
            $this->repository->create($request, $deal)
        );

        return $resource->withLocation('deals.surveys.index', [$deal]);
    }
}
