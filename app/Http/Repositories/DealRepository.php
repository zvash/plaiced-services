<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Country;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealRepository extends Repository
{
    /**
     * Update deal shipping information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Deal
     *
     * @throws \Throwable
     */
    public function shipping(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            [$relations, $attributes] = collect($request->validated())->partition(
                fn ($attribute, $key) => in_array($key, ['country_id'])
            );

            $deal->country()->associate(
                Country::byUuid($relations->first())->firstOrFail()
            );

            return tap($deal->fill($attributes->toArray()))
                ->addTimeline('DealShipping:Update')
                ->save();
        };
    }

    /**
     * Request media accountability on deal.
     *
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Deal
     *
     * @throws \Throwable
     */
    public function mediaAccountability(Deal $deal)
    {
        $callback = fn (Deal $deal) => tap($deal)
            ->addTimeline('Deal:MediaAccountability')
            ->mediaAccountability(Deal::MEDIA_ACCOUNTABILITY_PENDING);

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Request content coordination on deal.
     *
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Deal
     *
     * @throws \Throwable
     */
    public function contentCoordination(Deal $deal)
    {
        $callback = fn (Deal $deal) => tap($deal)
            ->addTimeline('Deal:ContentCoordination')
            ->contentCoordination(Deal::COORDINATE_ADDED_VALUE_PENDING);

        return $this->transaction($callback, ...func_get_args());
    }
}
