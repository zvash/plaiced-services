<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ContentRepository as Repository;
use App\Http\Requests\StoreContentRequest;
use App\Http\Resources\ContentResource;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Models\ContentCreator;
use Illuminate\Http\Request;

class ContentCreatorContentController extends Controller
{
    /**
     * Content repository.
     *
     * @var \App\Http\Repositories\ContentRepository
     */
    protected $repository;

    /**
     * Content creator content controller constructor.
     *
     * @param  \App\Http\Repositories\ContentRepository  $repository
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, ContentCreator $contentCreator)
    {
        $query = $contentCreator->contents()->latest();

        return ContentSummaryResource::collection(
            $request->has('no-pagination')
                ? $query->get()
                : $query->paginate(15)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContentRequest  $request
     * @param  \App\Models\ContentCreator  $contentCreator
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreContentRequest $request, ContentCreator $contentCreator)
    {
        $this->authorize('create', [$this, $contentCreator]);

        $resource = new ContentResource(
            $content = $this->repository->create($request, $contentCreator)
        );

        return $resource->withLocation('contents.show', [$content]);
    }
}
