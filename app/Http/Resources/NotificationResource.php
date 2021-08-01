<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
        return[
            'uuid' => $this->id,
            'type' => $this->type,
            'data' => $this->when($this->data, $this->data),
            'read' => $this->read(),
            'read_at' => $this->whenHasDate('read_at'),
            'created_at' => $this->whenHasDate('created_at'),
        ];
    }
}
