<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealSurveyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plaiced_rating' => 'required|integer|between:0,5',
            'plaiced_what_i_like' => 'sometimes|required|string|max:1000',
            'plaiced_what_can_get_better' => 'sometimes|required|string',
            'other_party_rating' => 'required|integer|between:0,5',
            'other_party_what_i_like' => 'sometimes|required|string',
            'other_party_comment' => 'sometimes|required|string',
        ];
    }
}
