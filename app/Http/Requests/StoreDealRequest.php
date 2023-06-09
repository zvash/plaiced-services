<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\DealConstants;
use Illuminate\Foundation\Http\FormRequest;

class StoreDealRequest extends FormRequest
{
    use DealConstants;

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
            'ownership_type' => 'required|integer|'.$this->getOwnershipType(),
            'exposure_expectations' => 'required|integer|'.$this->getExposureExpectations(),
            'content_creator_gets' => 'sometimes|required|string',
            'flexible_date' => 'required|boolean',

            // Dropdown parameters
            'advertiser_gets' => 'required|array',
            'advertiser_gets.*' => 'required|integer|exists:dropdowns,id',
            'arrival_speed' => 'required|array',
            'arrival_speed.*' => 'required|integer|exists:dropdowns,id',
        ];
    }
}
