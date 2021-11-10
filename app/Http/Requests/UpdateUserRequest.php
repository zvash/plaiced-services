<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'sometimes|required|regex:/^[\pL\pM\s-]+$/u|max:50',
            'last_name' => 'sometimes|required|regex:/^[\pL\pM\s-]+$/u|max:50',
            'avatar' => 'sometimes|nullable|file|mimes:jpg,jpeg,png|dimensions:ratio=1/1,max_width=500,max_height=500|max:1024',
            'company_position' => 'sometimes|required|string',
        ];
    }
}
