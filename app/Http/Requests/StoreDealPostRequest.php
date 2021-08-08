<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|string',
            'assets' => 'sometimes|required|array|max:10',
            'assets.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf,zip|max:1024',
            'assets.*.title' => 'required|string|max:255',
        ];
    }
}
