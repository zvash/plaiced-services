<?php

namespace App\Http\Resources;

use App\Models\Pivots\ContentTalent;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentResource extends JsonResource
{
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
            'type' => $this->whenPivotLoaded(
                new ContentTalent, fn () => new DropdownResource(
                    $this->pivot->load('type')->getRelation('type')
                )
            ),
        ];
    }
}
