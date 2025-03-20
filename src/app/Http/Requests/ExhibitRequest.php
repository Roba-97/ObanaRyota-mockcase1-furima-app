<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitRequest extends FormRequest
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
            'image' => 'required|file|mimes:jpg,png',
            'categories' => 'required',
            'condition_id' => 'required',
            'name' => 'required',
            'detail' => 'required|max:255',
            'price' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像をアップロードしてください',
            'image.file' => '商品画像はファイル形式でアップロードしてください',
            'image.mimes' => '拡張子がjpgまたはpngの商品画像をアップロードしてください',
            'categories.required' => 'カテゴリーを1つ以上選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'detail.required' => '商品説明を入力してください',
            'detail.max' => '商品説明は:max以下で入力してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '商品価格は整数値で入力してください',
            'price.min' => '商品価格は:min円以上を設定してください',
        ];
    }
}
