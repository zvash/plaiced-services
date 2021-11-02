<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Abstraction\Repository;
use App\Models\Abstraction\SurveyProvider;
use App\Models\AdvertiserSurvey;
use App\Models\ContentCreatorSurvey;
use App\Models\Deal;
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
     * @throws \Throwable
     */
    public function create(Request $request, Deal $deal)
    {
        $callback = function (Request $request, Deal $deal) {
            $survey = $this->survey($request, $deal);

            $this->rating($survey)->timeline($survey);

            return $survey;
        };

        return $this->transaction($callback, ...func_get_args());
    }

    /**
     * Create survey base on user class.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deal  $deal
     * @return \App\Models\Abstraction\SurveyProvider
     */
    private function survey(Request $request, Deal $deal)
    {
        $user = $request->user();

        $survey = $user->isAdvertiser()
            ? new ContentCreatorSurvey($request->validated())
            : new AdvertiserSurvey($request->validated());

        $survey->user()->associate($user);
        $survey->deal()->associate($deal);

        return tap($survey)->save();
    }

    /**
     * Update rating and rating_count on owner model.
     *
     * @param  \App\Models\Abstraction\SurveyProvider  $survey
     * @return $this
     */
    private function rating(SurveyProvider $survey)
    {
        [$relation, $owner] = $this->resolve($survey);

        $callback = fn (Builder $query) => $query->whereKey($owner->id);

        $rating = $survey->newQuery()
            ->whereHas($relation, $callback)
            ->avg('other_party_rating') ?: 0;

        $owner->increment('rating_count', 1, compact('rating'));

        return $this;
    }

    /**
     * Add timeline for created survey.
     *
     * @param  \App\Models\Abstraction\SurveyProvider  $survey
     * @return $this
     */
    private function timeline(SurveyProvider $survey)
    {
        $deal = $survey->deal;

        $title = $survey instanceof AdvertiserSurvey
            ? $deal->content->contentCreator->title
            : $deal->brand->advertiser->title;

        $deal->addTimeline('DealSurvey:Create', compact('title'));

        return $this;
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
