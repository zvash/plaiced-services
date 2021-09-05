<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'description' => $this->whenHasValue('description'),
            'small_description' => $this->whenHasValue('small_description'),
            'file_name' => $this->whenHasValue('file_name'),
            'mime_type' => $this->whenHasValue('mime_type'),
            'extension' => $this->whenHasValue('extension'),
            'size' => $this->whenHasValue('size'),
            'url' => $this->whenHasFile('url'),
        ];
    }
}
