<?php

namespace App\Http\Resources;

use App\Http\Resources\Summaries\BrandSummaryResource;
use App\Http\Resources\Summaries\ContentSummaryResource;
use App\Http\Resources\Summaries\UserSummaryResource;
use App\Http\Resources\Traits\HasJsonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'synopsis' => $this->whenHasValue('synopsis'),
            'viewership_metrics' => $this->whenHasValue('viewership_metrics'),
            'content_creator_gets' => $this->whenHasValue('content_creator_gets'),
            'advertiser_gets' => $this->loadDropdownCollection('advertiser_gets'),
            'advertiser_benefits' => $this->whenHasValue('advertiser_benefits'),
            'arrival_speed' => $this->loadDropdownCollection('arrival_speed'),
            'arrival_speed_brief' => $this->whenHasValue('arrival_speed_brief'),
            'coordinate_added_value' => $this->whenHasValue('coordinate_added_value'),
            'media_accountability' => $this->whenHasValue('media_accountability'),
            'owner' => $this->owner->user->is($request->user()),
            'flexible_date' => $this->flexible_date,
            'type' => $this->type,
            'status' => $this->status,
            'is_public' => $this->is_public,
            'ownership_type' => $this->ownership_type,
            'exposure_expectations' => $this->exposure_expectations,
            'shipping_contact_name' => $this->whenHasValue('shipping_contact_name'),
            'shipping_contact_telephone' => $this->whenHasValue('shipping_contact_telephone'),
            'shipping_tracking_code' => $this->whenHasValue('shipping_tracking_code'),
            'shipping_url' => $this->whenHasValue('shipping_url'),
            'shipping_company' => $this->whenHasValue('shipping_company'),
            'shipping_submitted_at' => $this->whenHasDate('shipping_submitted_at'),
            'shipping_submitted_by' => $this->when($this->shipping_submitted_by, fn () => new UserSummaryResource($this->submittedBy)),
            'address' => $this->whenHasValue('address'),
            'city' => $this->whenHasValue('city'),
            'state' => $this->whenHasValue('state'),
            'postal_code' => $this->whenHasValue('postal_code'),
            'country' => $this->whenLoadedAndNotEmpty('country'),
            'content' => new ContentSummaryResource($this->content),
            'brand' => new BrandSummaryResource($this->brand),
        ];
    }
}
