<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\ContentCreatorSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'featured' => $this->featured,
            'synopsis' => $this->whenHasValue('synopsis'),
            'viewership_metrics' => $this->whenHasValue('viewership_metrics'),
            'general_comment' => $this->whenHasValue('general_comment'),
            'avatar' => $this->whenHasFile('avatar'),
            'shipping_contact_name' => $this->whenHasValue('shipping_contact_name'),
            'shipping_contact_telephone' => $this->whenHasValue('shipping_contact_telephone'),
            'address' => $this->whenHasValue('address'),
            'city' => $this->whenHasValue('city'),
            'state' => $this->whenHasValue('state'),
            'postal_code' => $this->whenHasValue('postal_code'),
            'country' => $this->whenLoadedAndNotEmpty('country'),
            'locations' => $this->loadDropdownCollection('locations'),
            'demographic_age' => $this->loadDropdownCollection('demographic_age'),
            'demographic_gender' => $this->loadDropdownCollection('demographic_gender'),
            'demographic_geography_id' => $this->loadDropdownCollection('demographic_geography_id'),
            'viewership' => $this->whenLoadedDropdown('viewership'),
            'genre' => $this->whenLoadedDropdown('genre'),
            'category' => $this->whenLoadedDropdown('category'),
            'subcategory' => $this->whenLoadedDropdown('subcategory'),
            'child_subcategory' => $this->whenLoadedDropdown('childSubcategory'),
            'content_creator' => new ContentCreatorSummaryResource($this->contentCreator),
            'assets' => AssetResource::collection($this->whenHasCollection('assets')),
            'socials' => SocialResource::collection($this->whenHasCollection('socials')),
            'talents' => TalentResource::collection($this->whenHasCollection('talents')),
        ];
    }
}
