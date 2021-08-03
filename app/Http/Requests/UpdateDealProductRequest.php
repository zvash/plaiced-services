<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDealProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer|gt:0',
            'sku' => 'sometimes|required|string|max:255',
            'website' => 'sometimes|required|url',
        ];
    }
}
