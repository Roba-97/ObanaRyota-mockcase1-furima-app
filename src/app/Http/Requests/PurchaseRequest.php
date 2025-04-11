<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment' => 'required',
            'delivery_address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'payment.required' => '支払い方法を選択してください',
            'delivery_address.required' => '配送先住所を指定してください',
        ];
    }
}
