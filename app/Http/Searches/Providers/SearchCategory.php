<?php

namespace App\Http\Searches\Providers;

use App\Http\Resources\DropdownResource;
use App\Http\Searches\Abstractions\SearchProvider;
use App\Http\Searches\Interfaces\Searchable;
use App\Models\Brand;
use App\Models\Content;
use App\Models\Dropdown;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SearchCategory extends SearchProvider implements Searchable
{
    /**
     * Search database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function search()
    {
        $categories = collect()
            ->merge($this->find('category'))
            ->merge($this->find('subcategory'))
            ->when(
                $this->getUser()->isAdvertiser(),
                fn (Collection $collection) => $collection->merge(
                    $this->find('childSubcategory')
                )
            );

        return Dropdown::whereIn('id', $categories)->get();
    }

    /**
     * Create base builder to perform query on database.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder()
    {
        return $this->getUser()->isAdvertiser()
            ? Content::query()->distinct()
            : Brand::query()->distinct();
    }

    /**
     * Default resource class for fetched result.
     *
     * @return string
     */
    public function getResource()
    {
        return DropdownResource::class;
    }

    /**
     * Find categories base on their relations.
     *
     * @param  string  $relation
     * @return \Illuminate\Support\Collection
     */
    private function find(string $relation)
    {
        return $this->getBuilder()
            ->whereHas(
                $relation,
                fn (Builder $query) => $query->where('title', 'like', $this->getSearchQuery())
            )
            ->pluck(Str::snake($relation));
    }
}
