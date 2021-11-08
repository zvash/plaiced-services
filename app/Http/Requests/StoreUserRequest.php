<?php

namespace App\Http\Requests;

use App\Models\Advertiser;
use App\Models\ContentCreator;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'regex:/^[\pL\pM\s-]+$/u|max:50',
            'last_name' => 'regex:/^[\pL\pM\s-]+$/u|max:50',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8',
            'class' => 'required|in:' . ContentCreator::class . ',' . Advertiser::class . ',content-creator,advertiser',
            'find_us' => 'sometimes|nullable|string',
            'avatar' => 'sometimes|nullable|file|mimes:jpg,jpeg,png|dimensions:ratio=1/1,max_width=500,max_height=500|max:1024',
            'title' => 'required|string',
            'small_description' => 'required',
            'description' => 'required',
            'website' => 'sometimes|nullable|url',
            'telephone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:30',
            'alt_telephone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:30',
            'address' => 'sometimes|nullable',
            'city' => 'sometimes|nullable',
            'state' => 'sometimes|nullable',
            'postal_code' => 'sometimes|nullable|max:30',
            'country_id' => 'sometimes|integer|exists:countries,id',
            'type' => 'required|integer|exists:dropdowns,id',
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

        $classTypes = [
            'content-creator' => ContentCreator::class,
            'advertiser' => Advertiser::class,
        ];
        $class = $this->get('class', 0);
        if (isset($classTypes[$class])) {
            $this->merge([
                'class' => $classTypes[$class],
            ]);
        }
    }
}
