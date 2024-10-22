<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        $imgRule = \request()->isMethod('post') ? 'required' : 'nullable';
        $variantRule =  \request()->isMethod('post') ? 'required' : 'nullable';

        return [
            'variant_ids' => $variantRule . '|array',
            'variant_ids.*' => 'exists:variants,id',
            'name' => 'required|string|max:256',
            'description' => 'nullable',
            'name_bn' => 'nullable|string|max:256',
            'description_bn' => 'nullable',
            'image' => [$imgRule, 'image', 'mimes:jpg,jpeg,png,gif'],
        ];
        return [];
    }


}
