<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ContentRepository as Repository;
use App\Http\Resources\ContentResource;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Models\Content;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Content repository.
     *
     * @var \App\Http\Repositories\ContentRepository
     */
    protected $repository;

    /**
     * Content controller constructor.
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $contents = Content::when($request->has('feature'),
            fn (Builder $query, bool $feature) => $query->whereFeatured($feature)
        )->latest()->paginate(15);

        return ContentSummaryResource::collection($contents);
    }

    /**
     * Display the specified resource listing.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Content $content)
    {
        return new ContentResource(
            $content->load([
                'viewership',
                'genre',
                'category',
                'subcategory',
                'childSubcategory',
            ])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Content  $content
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     */
    public function destroy(Content $content)
    {
        $this->authorize('delete', [$this, $content]);

        $this->repository->delete($content);

        return response()->noContent();
    }
}
