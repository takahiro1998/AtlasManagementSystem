<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
        $main_category=$this->input('main_category_id');
        $sub_category=$this->input('sub_category_name');

        $this->merge([
                'main_category'=>$main_category,
                'sub_category'=>$sub_category
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
            'main_category'=>'required|exists:main_categories',
            'sub_category'=>'required|max:100|string|unique:sub_categories'
            //
        ];
    }

    public function messages(){
        return [
            'sub_category.required'=>'サブカテゴリは入力必須です',
            'sub_category.unique'=>'すでに登録されています',
        ];
    }
}
