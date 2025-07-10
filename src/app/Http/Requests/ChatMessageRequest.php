<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatMessageRequest extends FormRequest
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
            'content' => 'required|max:400',
            'image' => 'nullable|mimes:jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '本文を入力してください',
            'content.max' => '本文は:max文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpg」形式でアップロードしてください',
        ];
    }
}
