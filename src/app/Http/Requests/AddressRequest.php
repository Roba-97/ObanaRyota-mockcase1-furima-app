<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'postcode' => ['required', 'regex:/[0-9]{3}-[0-9]{4}/'],
            'address' => 'required',
            'building' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号はハイフンを含む半角数字で入力してください',
            'address.required' => '住所を入力してください',
            'building.required' => '建物名を入力してください',
        ];
    }
}
