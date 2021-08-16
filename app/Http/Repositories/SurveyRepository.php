<?php

namespace App\Http\Repositories;

use App\Exceptions\UserException;
use App\Http\Repositories\Abstraction\Repository;
use App\Models\Abstraction\SurveyProvider;
use App\Models\Advertiser;
use App\Models\AdvertiserSurvey;
use App\Models\ContentCreator;
use App\Models\ContentCreatorSurvey;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SurveyRepository extends Repository
{
    /**
     * Create a survey.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal $deal
     * @return \App\Models\Abstraction\SurveyProvider
     *
     * @throws \App\Exceptions\UserException
     */
    public function create(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            $survey = $this->survey($request->validated(), $request->user(), $deal);

            $this->rating($survey);

            return $survey;
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Create survey base on user class.
     *
     * @param  array  $attributes
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Abstraction\SurveyProvider
     *
     * @throws \App\Exceptions\UserException
     */
    private function survey(array $attributes, User $user, Deal $deal)
    {
        switch ($user->class) {
            case Advertiser::class:
                $survey = new ContentCreatorSurvey($attributes);
                break;

            case ContentCreator::class:
                $survey = new AdvertiserSurvey($attributes);
                break;

            default:
                throw new UserException('Invalid user class.');
        }

        $survey->user()->associate($user);
        $survey->deal()->associate($deal);

        return tap($survey)->save();
    }

    /**
     * Update rating and rating_count on owner model.
     *
     * @param  \App\Models\Abstraction\SurveyProvider  $survey
     * @return int
     */
    private function rating(SurveyProvider $survey)
    {
        [$relation, $owner] = $this->resolve($survey);

        $callback = fn (Builder $query) => $query->whereKey($owner->id);

        $rating = $survey->newQuery()
            ->whereHas($relation, $callback)
            ->avg('other_party_rating') ?: 0;

        return $owner->increment('rating_count', 1, compact('rating'));
    }

    /**
     * Resolve owner and its relationship with survey model.
     *
     * @param \App\Models\Abstraction\SurveyProvider $survey
     * @return array
     */
    private function resolve(SurveyProvider $survey)
    {
        return $survey instanceof AdvertiserSurvey
            ? ['deal.brand.advertiser', $survey->deal->brand->advertiser]
            : ['deal.content.contentCreator', $survey->deal->content->contentCreator];
    }
}
