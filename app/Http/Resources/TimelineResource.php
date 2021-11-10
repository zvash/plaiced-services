<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TimelineResource extends JsonResource
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
            'parameters' => $this->whenHasCollection('parameters'),
            'description' => $this->getDescription(),
            'type' => $this->getMorphType('model'),
            'object' => $this->getMorphResource('model'),
            'created_at' => $this->whenHasDate('created_at'),
        ];
    }

    /**
     * Get timeline description base on morph model.
     *
     * @return string
     */
    private function getDescription()
    {
        if ($this->model instanceof Post) {
            return $this->model->description;
        }

        if (! Str::contains($this->model->template, ':')) {
            return $this->model->template;
        }

        $parameters = $this->parameters->map(
            fn ($parameter) => ! is_array($parameter) ? $parameter : collect($parameter)
                    ->transform(fn ($item, $key) => $key.': '.$item)
                    ->join(', ', __(' and '))
        );

        return trans($this->model->template, $parameters->toArray());
    }
}
