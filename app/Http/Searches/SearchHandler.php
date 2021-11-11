<?php

namespace App\Http\Searches;

use App\Http\Searches\Interfaces\Searchable;
use Illuminate\Support\Str;

class SearchHandler
{
    /**
     * An object with searchable interface.
     *
     * @var \App\Http\Searches\Interfaces\Searchable
     */
    protected $searchable;

    /**
     * Search handler constructor.
     *
     * @param  \App\Http\Searches\Interfaces\Searchable  $searchable
     * @return void
     */
    public function __construct(Searchable $searchable)
    {
        $this->searchable = $searchable;
    }

    /**
     * Run search method on searchable object and create a resource collection.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search()
    {
        return $this->searchable->getResource()::collection(
            $this->searchable->search()
        );
    }

    /**
     * Generate a key for response result.
     *
     * @return string
     */
    public function getKey()
    {
        return (string) Str::of($this->searchable->getResource())
            ->classBasename()
            ->remove(['Summary', 'Resource'])
            ->plural()
            ->snake();
    }
}
