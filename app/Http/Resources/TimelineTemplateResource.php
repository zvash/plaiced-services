<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineTemplateResource extends JsonResource
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
            'event' => $this->event_name,
            'template' => $this->template,
            'icon' => $this->whenHasValue('icon'),
        ];
    }
}
