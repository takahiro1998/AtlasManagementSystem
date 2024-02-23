<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostEditFormRequest extends FormRequest
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
            'post_title' => 'min:4|string|max:100',
            'post_body' => 'min:10|string|max:5000',
        ];
    }

    public function messages(){
        return [
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_title.string'=>'タイトルには文字を指定してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
            'post_body.string'=>'内容には文字を指定してください。',
        ];
    }
}
