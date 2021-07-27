<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'slug' => $this->slug,
            'small_description' => $this->small_description,
            'description' => $this->description,
            'image' => $this->whenHasFile('image'),
            'featured' => $this->featured,
            'tags' => $this->whenHasCollection('tags'),
            'seo_title' => $this->seo_title ?? $this->title,
            'seo_description' => $this->seo_description ?? $this->small_description,
            'seo_image' => $this->whenHasFile($this->seo_image ? 'seo_image' : 'image'),
            'created_at' => $this->whenHasDate('created_at'),
        ];
    }
}
