<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Http\Searches\Providers\SearchCategory;
use App\Http\Searches\Providers\SearchHolding;
use App\Http\Searches\Providers\SearchParent;
use App\Http\Searches\SearchHandler;
use Illuminate\Http\Request;

class SearchRepository extends Repository
{
    /**
     * Search database base on criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Generator
     */
    public function search(Request $request)
    {
        foreach ($this->getCriteria() as $criterion) {
            $searchable = new $criterion($request);

            $handler = new SearchHandler($searchable);

            yield [$handler->getKey() => $handler->search()];
        }
    }

    /**
     * Get search criteria.
     *
     * @return array
     */
    private function getCriteria()
    {
        return  [
            SearchParent::class,
            SearchHolding::class,
            SearchCategory::class,
        ];
    }
}
