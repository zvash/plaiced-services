<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'description' => 'required|string',
            'general_comment' => 'required|string',
            'avatar' => 'required|file|mimes:jpg,jpeg,png|dimensions:ratio=1/1,max_width=500,max_height=500|max:1024',
            'assets' => 'sometimes|required|array|max:10',
            'assets.*.file' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'assets.*.title' => 'required|string|max:255',
            'videos' => 'sometimes|required|array|max:5',
            'videos.*.url' => 'required|active_url',
            'videos.*.title' => 'required|string|max:255',
            'socials' => 'sometimes|required|array:website,facebook,instagram,twitter,linkedin',
            'socials.*' => 'required|active_url',

            // Dropdown parameters
            'category' => 'required|integer|exists:dropdowns,id',
            'subcategory' => 'required|integer|exists:dropdowns,id',
            'locations' => 'required|array',
            'locations.*' => 'required|integer|exists:dropdowns,id',
            'demographic_age' => 'required|array',
            'demographic_age.*' => 'required|integer|exists:dropdowns,id',
            'demographic_gender' => 'required|array',
            'demographic_gender.*' => 'required|integer|exists:dropdowns,id',
            'demographic_income' => 'required|array',
            'demographic_income.*' => 'required|integer|exists:dropdowns,id',
            'demographic_marital_status' => 'required|array',
            'demographic_marital_status.*' => 'required|integer|exists:dropdowns,id',
            'demographic_type_of_families' => 'required|array',
            'demographic_type_of_families.*' => 'required|integer|exists:dropdowns,id',
            'demographic_household_size' => 'required|array',
            'demographic_household_size.*' => 'required|integer|exists:dropdowns,id',
            'demographic_race' => 'required|array',
            'demographic_race.*' => 'required|integer|exists:dropdowns,id',
            'demographic_education' => 'required|array',
            'demographic_education.*' => 'required|integer|exists:dropdowns,id',
            'demographic_geography' => 'required|array',
            'demographic_geography.*' => 'required|integer|exists:dropdowns,id',
            'demographic_psychographic' => 'required|array',
            'demographic_psychographic.*' => 'required|integer|exists:dropdowns,id',
        ];
    }
}
