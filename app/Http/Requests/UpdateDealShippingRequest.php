<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDealShippingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipping_contact_name' => 'required|string|max:255',
            'shipping_contact_telephone' => 'required|string|max:30',
            'shipping_tracking_code' => 'required|string|max:255',
            'shipping_url' => 'required|url',
            'shipping_company' => 'required|string|max:255',
            'shipping_submitted_at' => 'required|date|date_format:Y-m-d H:i:s',
            'shipping_submitted_by' => 'required|integer|exists:users,id',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:30',
            'country_id' => 'required|uuid|exists:countries,uuid',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'shipping_submitted_at' => now()->toDateTimeString(),
            'shipping_submitted_by' => $this->user()->id,
        ]);
    }
}
