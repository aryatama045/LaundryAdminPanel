<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $imgRule = 'required';
        if (request()->routeIs('product.subproduct.store')) {
            $imgRule = 'nullable';
        }
        if(request()->isMethod('put')){
            $imgRule = 'nullable';
        }

        return [
            'name' => ['required', 'string', 'max:256'],
            'name_bn' => ['nullable', 'string', 'max:256'],
            'slug' => ['nullable', 'string', 'max:256'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable'],
            'discount_price' => ['nullable', 'numeric'],
            'image' => [$imgRule, 'image', 'mimes:jpg,jpeg,png,gif,svg'],
            'service_id' => ['required', 'exists:services,id'],
            'variant_id' => ['required', 'exists:variants,id'],
        ];
    }

    public function messages()
    {
        return [
            'service_id.required' => 'The service field is required.'
        ];
    }
}
