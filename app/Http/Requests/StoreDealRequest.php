<?php

namespace App\Http\Requests;

use App\Models\Deal;
use Illuminate\Foundation\Http\FormRequest;

class StoreDealRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content_id' => 'required|uuid|exists:contents,uuid',
            'brand_id' => 'required|uuid|exists:brands,uuid',
            'ownership_type' => 'required|integer|in:'.$this->getOwnershipType(),
            'exposure_expectations' => 'required|integer|in:'.$this->getExposureExpectations(),
            'content_creator_gets' => 'nullable|string',
            'flexible_date' => 'required|boolean',

            // Dropdown parameters
            'advertiser_gets' => 'required|array',
            'advertiser_gets.*' => 'required|integer|exists:dropdowns,id',
            'arrival_speed' => 'required|array',
            'arrival_speed.*' => 'required|integer|exists:dropdowns,id',
        ];
    }

    /**
     * Get ownership type in rule.
     *
     * @return string
     */
    private function getOwnershipType()
    {
        return implode(',', [
            Deal::OWNERSHIP_TYPE_KEEP,
            Deal::OWNERSHIP_TYPE_LOAN
        ]);
    }

    /**
     * Get exposure expectation in rule.
     *
     * @return string
     */
    private function getExposureExpectations()
    {
        return implode(',', [
            Deal::EXPOSURE_EXPECTATIONS_MANDATORY,
            Deal::EXPOSURE_EXPECTATIONS_FLEXIBLE
        ]);
    }
}
