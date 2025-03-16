<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $itemId = $this->route('item')->id; // ルートパラメータから `item_id` を取得

        throw new HttpResponseException(
            redirect()->route('detail.index', ['item' => $itemId]) // 基本のリダイレクト
                ->withErrors($validator) // バリデーションエラーを渡す
                ->withInput() // 入力値を保持
                ->withFragment('comment-form') // #comment-form を追加
        );
    }

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
            'content' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'コメントを入力してください',
            'content.max' => 'コメントは255文字以内で入力してください',
        ];
    }
}
