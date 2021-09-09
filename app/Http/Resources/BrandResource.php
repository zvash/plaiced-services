<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\AdvertiserSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'description' => $this->description,
            'general_comment' => $this->whenHasValue('general_comment'),
            'avatar' => $this->whenHasFile('avatar'),
            'locations' => $this->loadDropdownCollection('locations'),
            'demographic_age' => $this->loadDropdownCollection('demographic_age'),
            'demographic_gender' => $this->loadDropdownCollection('demographic_gender'),
            'demographic_income' => $this->loadDropdownCollection('demographic_income'),
            'demographic_marital_status' => $this->loadDropdownCollection('demographic_marital_status'),
            'demographic_type_of_families' => $this->loadDropdownCollection('demographic_type_of_families'),
            'demographic_household_size' => $this->loadDropdownCollection('demographic_household_size'),
            'demographic_race' => $this->loadDropdownCollection('demographic_race'),
            'demographic_education' => $this->loadDropdownCollection('demographic_education'),
            'demographic_geography' => $this->loadDropdownCollection('demographic_geography'),
            'demographic_psychographic' => $this->loadDropdownCollection('demographic_psychographic'),
            'category' => $this->whenLoadedDropdown('category'),
            'subcategory' => $this->whenLoadedDropdown('subcategory'),
            'advertiser' => new AdvertiserSummaryResource($this->advertiser),
            'assets' => AssetResource::collection($this->whenHasCollection('assets')),
            'socials' => SocialResource::collection($this->whenHasCollection('socials')),
        ];
    }
}
