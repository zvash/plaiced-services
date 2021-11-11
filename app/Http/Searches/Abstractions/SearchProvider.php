<?php

namespace App\Http\Searches\Abstractions;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchProvider
{
    /**
     * The request that contains all the search parameters.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Search provider constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get logged-in user from request object.
     *
     * @return \App\Models\User
     */
    protected function getUser()
    {
        return $this->request->user();
    }

    /**
     * Get search query in lowercase from request.
     *
     * @return string
     */
    protected function getQuery()
    {
        return Str::lower($this->request->get('query'));
    }

    /**
     * Get search query for MySQL from request.
     *
     * @return string
     */
    protected function getSearchQuery()
    {
        return "%{$this->getQuery()}%";
    }
}
