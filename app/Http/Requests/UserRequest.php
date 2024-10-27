<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = auth()->id();
        if(\request()->routeIs('admin.update')){
            $userId = $this->userId;
        }
        $rule = [
            'company' => 'nullable',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'mobile' => ['nullable', 'numeric', "unique:users,mobile,$userId,id"],
            'email' => ['nullable', 'email', "unique:users,email,$userId,id"],
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'gender' => 'nullable',
            'alternative_phone' => 'nullable',
            'driving_lience' => 'nullable',
            'date_of_birth' => 'nullable',
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
