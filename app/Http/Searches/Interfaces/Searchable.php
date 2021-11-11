<?php

namespace App\Http\Searches\Interfaces;

interface Searchable
{
    /**
     * Search database.
     *
     * @return \Illuminate\Support\Collection
     */
    public function search();

    /**
     * Create base builder to perform query on database.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getBuilder();

    /**
     * Default resource class for fetched result.
     *
     * @return string
     */
    public function getResource();
}
