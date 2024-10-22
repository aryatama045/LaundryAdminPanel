<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
        $rule = [
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'mobile' => 'nullable|numeric|unique:users',
            'email' => 'nullable|email|unique:users|email',
            'password' => 'required|min:6|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ];

        if (!$this->email && !$this->mobile) {
           $rule['mobile'] = 'required';
        }
        return $rule;
    }
    public function messages()
    {
        return [
            'mobile.required' => 'The email or phone number field is required',
        ];
    }
}
