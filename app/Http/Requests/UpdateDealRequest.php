<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\DealConstants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDealRequest extends FormRequest
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
            'synopsis' => 'sometimes|required|string',
            'viewership_metrics' => 'sometimes|required|string',
            'content_creator_gets' => 'sometimes|required|string',
            'advertiser_benefits' => 'sometimes|required|string',
            'arrival_speed_brief' => 'sometimes|required|string',
            'ownership_type' => 'required|integer|'.$this->getOwnershipType(),
            'exposure_expectations' => 'required|integer|'.$this->getExposureExpectations(),
            'flexible_date' => 'required|boolean',

            // Dropdown parameters
            'advertiser_gets' => 'required|array',
            'advertiser_gets.*' => 'required|integer|exists:dropdowns,id',
            'arrival_speed' => 'required|array',
            'arrival_speed.*' => 'required|integer|exists:dropdowns,id',
        ];
    }
}
