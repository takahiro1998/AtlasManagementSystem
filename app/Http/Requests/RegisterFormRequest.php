<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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

    // ruleメゾットでバリデーションする前にデータを整理
    public function getValidatorInstance()
    {
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');
        // 3つのフィールドを連結する
        $birth_day = $old_year . '-' . $old_month . '-' . $old_day;
        // date関数にて取得した生年月日を格納する
        // $birth_day = date('Y-m-d', strtotime($data));

        $this->merge([
                'birth_day'=>$birth_day,
            ]);

        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'over_name'=> ['required' , 'string' , 'max:10'],
            'under_name'=> ['required' , 'string' , 'max:10'],
            'over_name_kana'=>['required' , 'string' , 'max:30' , 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
            'under_name_kana'=>['required' , 'string' , 'max:30' , 'regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u'],
            'mail_address'=>['required' , 'email' , 'unique:users' , 'max:100'],
            'sex'=>['required' , 'regex:/^[1|2|3]+$/u'],
            'old_year'=>['required'],
            'old_month'=>['required'],
            'old_day'=>['required'],
            'birth_day'=>['date' , 'before:tomorrow'],
            'role'=>['required' , 'regex:/^[1|2|3|4]+$/u'],
            'password'=>['required' , 'min:8' , 'max:30' , 'confirmed'],
            'password_confirmation' => ['required' , 'min:8' , 'max:30']
        ];
    }

    public function messages(){
        return [
            'over_name.required'=>'※入力してください。',
            'over_name.max'=>'※10文字以内で入力してください。',
            'under_name.required'=>'※入力してください。',
            'under_name.max'=>'※10文字以内で入力してください。',
            'mail_address.required'=>'入力してください。',
            'mail_address.email'  => '※メール形式で入力してください。',
            'mail_address.unique'=>'すでに登録されているメールアドレスです。',
            'mail.address.max'=>'100文字以内で入力してください。',
            'sex.required'=>'選択してください。',
            'birth_day.required' => '※生年月日が未入力です。',
            'password.required'=>'入力してください。',
            'password.min'=>'8文字以上で入力してください。',
            'password.max'=>'30文字以内で入力してください。',
            'password.confirmed'=>'パスワードが確認用パスワードと一致しません。',
            'password_confirmation.required'=>'入力してください。',
            'password_confirmation.min'=>'8文字以上で入力してください。',
            'password_confirmation.max'=>'30文字以内で入力してください。',
        ];
    }
}
