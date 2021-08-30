<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DropdownResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'value' => $this->value,
            'custom' => $this->custom,
            'group' => new DropDownGroupResource($this->group),
            'group_trailing' => $this->whenLoadedAndNotEmpty(
                'groupTrailing', DropDownGroupResource::class
            ),
        ];
    }
}
