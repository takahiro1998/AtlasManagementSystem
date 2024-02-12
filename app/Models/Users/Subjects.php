<?php

namespace App\Models\Users;


use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    public function users(){
        // 必要に応じてwithPivotなど使い中間テーブルの値を取得
        return $this->belongsToMany('App\Models\Users\User','subject_users','subject_id','user_id');// リレーションの定義
    }
}
