<?php

namespace App\Http\Resources;

use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'avatar' => $this->whenHasFile('avatar'),
            'find_us' => $this->find_us,
            'company_position' => $this->company_position,
            'class' => $this->class,
            'status' => $this->status,
        ];
    }
}
