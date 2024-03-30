<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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

    public function getValidatorInstance()
    {
        $main_category=$this->input('main_category_name');

        $this->merge([
                'main_category'=>$main_category,
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
            'main_category'=>['required','max:100','string','unique:main_categories']
            //
        ];
    }

     public function messages(){
        return [
            'main_category.required'  => 'メインカテゴリは入力必須です',
            'main_category.unique'=>'すでに登録されています',
            'main_category.max'=>'100文字以内で登録してください'
        ];
    }
}
