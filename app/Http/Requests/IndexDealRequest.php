<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\DealConstants;
use Illuminate\Foundation\Http\FormRequest;

class IndexDealRequest extends FormRequest
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
            'status' => 'sometimes|required|integer|'.$this->getStatuses(),
        ];
    }
}
