<?php

namespace App\Http\Resources\Summaries;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentSummaryResource extends JsonResource
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
            'title' => $this->title,
            'avatar' => $this->whenHasFile('avatar'),
        ];
    }
}
