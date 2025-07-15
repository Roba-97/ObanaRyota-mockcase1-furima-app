<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateChatMessageRequest extends FormRequest
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
            'update_content' => 'required|max:400',
        ];
    }

    public function messages()
    {
        return [
            'update_content.required' => '本文を入力するか、削除ボタンから削除が可能です',
            'update_content.max' => 'メッセージの編集は:max文字以内で入力してください',
        ];
    }
}
