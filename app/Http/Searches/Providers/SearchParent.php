<?php

namespace App\Http\Searches\Providers;

use App\Http\Resources\Summaries\AdvertiserSummaryResource;
use App\Http\Resources\Summaries\ContentCreatorSummaryResource;
use App\Http\Searches\Abstractions\SearchProvider;
use App\Http\Searches\Interfaces\Searchable;
use App\Models\Advertiser;
use App\Models\ContentCreator;

class SearchParent extends SearchProvider implements Searchable
{
    /**
     * Search database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function search()
    {
        $searchQuery = $this->getSearchQuery();

        return $this->getBuilder()
            ->where('title', 'like', $searchQuery)
            ->orWhere('description', 'like', $searchQuery)
            ->orWhere('small_description', 'like', $searchQuery)
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
        return $this->getUser()->isAdvertiser()
            ? ContentCreator::query()
            : Advertiser::query();
    }

    /**
     * Default resource class for fetched result.
     *
     * @return string
     */
    public function getResource()
    {
        return $this->getUser()->isAdvertiser()
            ? ContentCreatorSummaryResource::class
            : AdvertiserSummaryResource::class;
    }
}
