<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexSortRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_by' => 'required|in:title,created_at,rating,rating_count',
            'sort_type' => 'required|in:asc,desc',
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
            'sort_by' => $this->query('sort_by', 'created_at'),
            'sort_type' => $this->query('sort_type', 'desc'),
        ]);
    }
}
