<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'content' => 'nullable|max:400',
            'image' => 'nullable|file|mimes:jpg,png',
        ];
    }

    public function messages()
    {
        return [
            'content.max' => '本文は:max文字以内で入力してください',
            'image.file' => '画像はファイルである必要があります',
            'image.mimes' => '「.png」または「.jpg」形式でアップロードしてください',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if(!$this->content && !$this->image) {
                $validator->errors()->add('content', '送信する内容がありません');
            }
        });
    }
}
