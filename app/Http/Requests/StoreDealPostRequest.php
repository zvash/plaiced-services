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
            'assets.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,ppt,pptx,xls,xlsx|max:1024',
            'assets.*.title' => 'required|string|max:255',
            'videos' => 'sometimes|required|array|max:5',
            'videos.*.url' => 'required|active_url',
            'videos.*.title' => 'required|string|max:255',
        ];
    }
}
