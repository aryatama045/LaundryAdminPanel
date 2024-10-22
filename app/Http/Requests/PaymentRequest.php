<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'order_id' => ['required','exists:' . (new Order())->getTable() . ',id'],
            'object' => 'required',
            'brand' => 'required',
            'status' => 'required',
            'exp' => 'required',
            'last_no' => 'required|numeric',
            'transaction' => 'required',
            'amount' => 'required',
        ];
    }
}
