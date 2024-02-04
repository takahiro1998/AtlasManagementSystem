<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    public function registerPost(Request $request)
    {
        // $validator=Validator::make($request->all(),[
        //         'over_name'=>'required|string|max:10',
        //         'under_name'=>'required|string|max:10',
        //         'over_name_kana'=>'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
        //         'under_name_kana'=>'required|string|max:30|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u',
        //         'mail_address'=>'required|email|unique:users|max:100',
        //         'sex'=>'required|regex:/^[1|2|3]+$/u',
        //         'old_year'=>'required',
        //         'old_month'=>'required',
        //         'old_day'=>'required',
        //         'birth_day'=>'required|date|after:1999-12-31|before:tomorrow',
        //         'role'=>'required|regex:/^[1|2|3|4]+$/u',
        //         'password'=>'required|min:8|max:30|confirmed',
        //         'password_confirmation' => 'required|min:8|max:30'
        //     ]);
        //     if($validator->fails()){
        //         return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        //     }
        // トランザクション処理・・・誤って一部分のみ登録を防ぐ処理
        DB::beginTransaction();
        try{

            // 生年月日フォームの各フィールドを格納する
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            // 3つのフィールドを連結する
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            // date関数にて取得した生年月日を格納する
            $birth_day = date('Y-m-d', strtotime($data));

            // dd($birth_day);

            // $this->merge([
            //     'birth_day'=>$birth_day,
            // ]);

            $subjects = $request->subject;


            // バリデーションに引っかかる場合
          // それ以外
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            // モデルが見つからない場合
            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);
                        DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            // ロールバック（破棄）
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
