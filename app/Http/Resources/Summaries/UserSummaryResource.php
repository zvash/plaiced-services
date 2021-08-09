<?php

namespace App\Http\Resources\Summaries;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSummaryResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->whenHasFile('avatar'),
        ];
    }
}
