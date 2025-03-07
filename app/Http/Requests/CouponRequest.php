<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => ['required'],
            // 'discount_type' => ['required'],
            // 'discount' => ['required'],
            // 'start_date' => ['required'],
            // 'start_time' => ['required'],
            // 'min_amount' => ['required'],
            // 'expired_date' => ['required'],
            // 'expired_time' => ['required'],
        ];
    }
}
