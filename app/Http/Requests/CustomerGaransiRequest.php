<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerGaransiRequest extends FormRequest
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

        $imgRule = request()->isMethod('put') ? 'nullable' : 'required';
        $rule = [
            'customer_id'           => 'required|string',
            'no_nota'               => 'required',
            'tanggal_nota'          => 'nullable',
            'no_pemasangan'         => 'nullable',
            'tanggal_pemasangan'    => 'nullable',
            'garansi_photo'         => [$imgRule, 'file', 'mimes:jpg,jpeg,png'],

        ];


        return $rule;
    }

    public function messages()
    {
        return [
            'no_nota.required' => 'No nota field is required',
        ];
    }
}
