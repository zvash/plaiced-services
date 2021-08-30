<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\AdvertiserSummaryResource as AdvertiserResource;
use App\Http\Resources\Summaries\ContentCreatorSummaryResource as ContentCreatorResource;
use App\Http\Resources\Summaries\UserSummaryResource as UserResource;
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
            'user' => new UserResource($this->user),
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
            ? ContentCreatorResource::class
            : AdvertiserResource::class;

        return $this->getMorphResource('followable', $resource);
    }
}
