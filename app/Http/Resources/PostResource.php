<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\UserSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'description' => $this->description,
            'user' => new UserSummaryResource($this->user),
            'assets' => AssetResource::collection($this->whenHasCollection('assets')),
        ];
    }
}
