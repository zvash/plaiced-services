<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Brand;
use App\Models\Content;
use App\Models\Country;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DealRepository extends Repository
{
    /**
     * Create a deal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Deal
     *
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $callback = function (Request $request) {
            [$relations, $attributes] = collect($request->validated())->partition(
                fn ($attribute, $key) => in_array($key, [
                    'content_id',
                    'brand_id',
                ])
            );

            $deal = $this->setRelations(
                new Deal($attributes->toArray()),
                $user = $request->user(),
                $relations
            );

            throw_unless($deal->authorize($user), AuthorizationException::class);

            $deal->save();

            return tap($deal)->addTimeline('Deal:Create', [
                'title' => $deal->owner->title,
            ]);
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Update a deal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Deal
     *
     * @throws \Throwable
     */
    public function update(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            return tap($deal->fill($request->validated()))->save();
        };

        return $this->transaction($callback, ...func_get_args());
    }

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

            $deal->fill($attributes->toArray())->save();

            return tap($deal)->addTimeline('DealShipping:Update');
        };

        return $this->transaction($callback, ...func_get_args());
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

    /**
     * Set relations on deal.
     *
     * @param  \App\Models\Deal  $deal
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Support\Collection  $relations
     * @return \App\Models\Deal
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    private function setRelations(Deal $deal, User $user, Collection $relations)
    {
        $relations = $relations->mapWithKeys(function (string $uuid, string $relation) {
            $model = $relation == 'brand_id' ? Brand::class : Content::class;

            return [Str::remove('_id', $relation) => $model::byUuid($uuid)->firstOrFail()];
        });

        $deal->content()->associate($relations->get('content'));
        $deal->brand()->associate($relations->get('brand'));

        $owner = $user->isAdvertiser()
            ? $relations->get('brand')->advertiser
            : $relations->get('content')->contentCreator;

        $deal->owner()->associate($owner);

        return $deal;
    }
}
