<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        $imgRule = request()->isMethod('put') ? 'nullable' : 'required';

        return [
            'title' => ['nullable', 'string', 'max:256'],
            'description' => ['nullable'],
            'image' => [$imgRule, 'image', 'mimes:jpg,jpeg,png,gis,svg'],
        ];
    }
}
