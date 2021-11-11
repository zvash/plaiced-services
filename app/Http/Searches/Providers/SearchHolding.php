<?php

namespace App\Http\Searches\Providers;

use App\Http\Resources\BrandResource;
use App\Http\Resources\ContentResource;
use App\Http\Searches\Abstractions\SearchProvider;
use App\Http\Searches\Interfaces\Searchable;
use App\Models\Brand;
use App\Models\Content;

class SearchHolding extends SearchProvider implements Searchable
{
    /**
     * Search database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function search()
    {
        return $this->getBuilder()
            ->orWhere('title', 'like', $this->getSearchQuery())
            ->orWhereJsonContains('keywords', $this->getQuery())
            ->take(30)
            ->get();
    }

    /**
     * Create base builder to perform query on database.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder()
    {
        $searchQuery = $this->getSearchQuery();

        return $this->getUser()->isAdvertiser()
            ? Content::where('synopsis', 'like', $searchQuery)
            : Brand::where('description', 'like', $searchQuery);
    }

    /**
     * Default resource class for fetched result.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->getUser()->isAdvertiser()
            ? ContentResource::class
            : BrandResource::class;
    }
}
