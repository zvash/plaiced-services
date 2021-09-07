<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string',
            'viewership_metrics' => 'required|string',
            'general_comment' => 'required|string',
            'avatar' => 'required|file|mimes:jpg,jpeg,png|dimensions:ratio=1/1,max_width=500,max_height=500|max:1024',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:30',
            'shipping_contact_name' => 'required|string|max:255',
            'shipping_contact_telephone' => 'required|string|max:30',
            'country_id' => 'required|integer|exists:countries,id',
            'assets' => 'sometimes|required|array|max:10',
            'assets.*.file' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'assets.*.title' => 'required|string|max:255',
            'videos' => 'sometimes|required|array|max:5',
            'videos.*.url' => 'required|active_url',
            'videos.*.title' => 'required|string|max:255',
            'socials' => 'sometimes|required|array:website,facebook,instagram,twitter,linkedin',
            'socials.*' => 'required|active_url',

            // Dropdown parameters
            'viewership' => 'required|integer|exists:dropdowns,id',
            'genre' => 'required|integer|exists:dropdowns,id',
            'category' => 'required|integer|exists:dropdowns,id',
            'subcategory' => 'required|integer|exists:dropdowns,id',
            'child_subcategory' => 'required|integer|exists:dropdowns,id',
            'locations' => 'required|array',
            'locations.*' => 'required|integer|exists:dropdowns,id',
            'demographic_age' => 'required|array',
            'demographic_age.*' => 'required|integer|exists:dropdowns,id',
            'demographic_gender' => 'required|array',
            'demographic_gender.*' => 'required|integer|exists:dropdowns,id',
            'demographic_geography_id' => 'required|array',
            'demographic_geography_id.*' => 'required|integer|exists:dropdowns,id',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $uuid = $this->get('country_id', 0);

        $this->merge([
            'country_id' => Country::byUuid($uuid)->value('id'),
        ]);
    }
}
