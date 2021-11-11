<?php

namespace App\Http\Controllers\Api\Searches;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SearchRepository as Repository;
use App\Http\Requests\IndexSearchRequest;
use App\Http\Resources\SearchResourceCollection;

class SearchController extends Controller
{
    /**
     * Search repository.
     *
     * @var \App\Http\Repositories\SearchRepository
     */
    protected $repository;

    /**
     * Search controller constructor.
     *
     * @param  \App\Http\Repositories\SearchRepository  $repository
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
     * @param  \App\Http\Requests\IndexSearchRequest  $request
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(IndexSearchRequest $request)
    {
        $this->authorize('perform', $this);

        $results = collect();

        foreach ($this->repository->search($request) as $result) {
            $results->push($result);
        }

        return new SearchResourceCollection(
            $results->mapWithKeys(fn ($result) => $result)
        );
    }
}
