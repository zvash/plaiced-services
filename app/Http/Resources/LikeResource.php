<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\AdvertiserSummaryResource as AdvertiserResource;
use App\Http\Resources\Summaries\BrandSummaryResource as BrandResource;
use App\Http\Resources\Summaries\ContentCreatorSummaryResource as ContentCreatorResource;
use App\Http\Resources\Summaries\ContentSummaryResource as ContentResource;
use App\Http\Resources\Summaries\UserSummaryResource as UserResource;
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
            'user' => new UserResource($this->user),
            $this->merge([
                $this->getParentKey() => $this->resolveParent(),
            ]),
        ];
    }

    /**
     * Get likable object.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\Resources\MissingValue
     */
    private function getObject()
    {
        $resource = $this->isContent() ? ContentResource::class : BrandResource::class;

        return $this->getMorphResource('likable', $resource);
    }

    /**
     * Get parent object.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    private function resolveParent()
    {
        $resource = $this->isContent() ? ContentCreatorResource::class : AdvertiserResource::class;

        return new $resource($this->getParent());
    }

    /**
     * Get parent model for likable object base on their type.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getParent()
    {
        return $this->isContent() ? $this->likable->contentCreator : $this->likable->advertiser;
    }

    /**
     * Get key for parent object.
     *
     * @return string
     */
    private function getParentKey()
    {
        return $this->isContent() ? 'content_creator' : 'advertiser';
    }

    /**
     * Check the like object and get type of it (content or brand).
     *
     * @return bool
     */
    private function isContent()
    {
        return $this->likable instanceof Content;
    }
}
