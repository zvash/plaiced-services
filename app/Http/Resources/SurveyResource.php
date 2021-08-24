<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\DealSummaryResource as DealResource;
use App\Http\Resources\Summaries\UserSummaryResource as UserResource;
use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    use HasJsonResource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'type' => get_class($this->resource),
            'plaiced_rating' => $this->plaiced_rating,
            'plaiced_what_i_like' => $this->whenHasValue('plaiced_what_i_like'),
            'plaiced_what_can_get_better' => $this->whenHasValue('plaiced_what_can_get_better'),
            'other_party_rating' => $this->whenHasValue('other_party_rating'),
            'other_party_what_i_like' => $this->whenHasValue('other_party_what_i_like'),
            'other_party_comment' => $this->whenHasValue('other_party_comment'),
            'user' => new UserResource($this->user),
            'deal' => new DealResource($this->deal),
        ];
    }
}
