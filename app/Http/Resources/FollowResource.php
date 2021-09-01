<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\AdvertiserSummaryResource;
use App\Http\Resources\Summaries\ContentCreatorSummaryResource;
use App\Http\Resources\Summaries\UserSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use App\Models\ContentCreator;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowResource extends JsonResource
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
            'type' => $this->getMorphType('followable'),
            'object' => $this->getObject(),
            'user' => new UserSummaryResource($this->user),
        ];
    }

    /**
     * Get followable object.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\Resources\MissingValue
     */
    private function getObject()
    {
        $resource = $this->likable instanceof ContentCreator
            ? ContentCreatorSummaryResource::class
            : AdvertiserSummaryResource::class;

        return $this->getMorphResource('followable', $resource);
    }
}
