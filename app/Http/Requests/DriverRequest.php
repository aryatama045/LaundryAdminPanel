<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'mobile' => 'nullable|numeric|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
