<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\BrandSummaryResource;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Http\Resources\Summaries\UserSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use App\Models\Content;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
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
            'type' => $this->getMorphType('likable'),
            'object' => $this->getObject(),
            'user' => new UserSummaryResource($this->user),
        ];
    }

    /**
     * Get likable object.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\Resources\MissingValue
     */
    private function getObject()
    {
        $resource = $this->likable instanceof Content
            ? ContentSummaryResource::class
            : BrandSummaryResource::class;

        return $this->getMorphResource('likable', $resource);
    }
}
