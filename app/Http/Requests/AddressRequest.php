<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_name' => ['required', 'string', 'max:256'],
            'road_no' => ['nullable'],
            'house_no' => ['nullable'],
            'house_name' => ['nullable'],
            'area' => ['required'],
            'flat_no' => ['nullable'],
            'sub_district_id' => ['nullable'],
            'district_id' => ['nullable'],
            'address_line' => ['nullable'],
            'address_line2' => ['nullable'],
            'delivery_note' => ['nullable'],
            'post_code' => ['nullable'],
            'latitude' => ['nullable'],
            'longitude' => ['nullable'],
        ];
    }
}
