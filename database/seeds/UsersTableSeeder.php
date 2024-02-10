<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'=>'9',
            'over_name'=>'生徒',
            'under_name'=>'太郎',
            'over_name_kana'=>'セイト',
            'under_name_kana'=>'タロウ',
            'mail_address'=>'tarou@test.com',
            'sex'=>'1',
            'role'=>'4',
            'birth_day'=>'1998-11-2',
            'password'=>bcrypt('seito123'),
        ]);

        User::create([
            'id'=>'2',
            'over_name'=>'生徒',
            'under_name'=>'次郎',
            'over_name_kana'=>'セイト',
            'under_name_kana'=>'ジロウ',
            'mail_address'=>'seitozirou@test.com',
            'sex'=>'1',
            'role'=>'4',
            'birth_day'=>'2000-11-2',
            'password'=>bcrypt('seito456'),
        ]);

        User::create([
            'id'=>'3',
            'over_name'=>'生徒',
            'under_name'=>'三郎',
            'over_name_kana'=>'セイト',
            'under_name_kana'=>'サブロウ',
            'mail_address'=>'seitosaburou@test.com',
            'sex'=>'1',
            'role'=>'4',
            'birth_day'=>'2001-11-2',
            'password'=>bcrypt('seito789'),
        ]);

        User::create([
            'id'=>'4',
            'over_name'=>'先生',
            'under_name'=>'太郎',
            'over_name_kana'=>'センセイ',
            'under_name_kana'=>'タロウ',
            'mail_address'=>'senseitarou@test.com',
            'sex'=>'1',
            'role'=>'1',
            'birth_day'=>'1990-1-1',
            'password'=>bcrypt('sensei123'),
        ]);

        User::create([
            'id'=>'5',
            'over_name'=>'先生',
            'under_name'=>'次郎',
            'over_name_kana'=>'センセイ',
            'under_name_kana'=>'ジロウ',
            'mail_address'=>'senseizirou@test.com',
            'sex'=>'1',
            'role'=>'2',
            'birth_day'=>'1985-5-5',
            'password'=>bcrypt('sensei456'),
        ]);

        User::create([
            'id'=>'6',
            'over_name'=>'先生',
            'under_name'=>'三郎',
            'over_name_kana'=>'センセイ',
            'under_name_kana'=>'サブロウ',
            'mail_address'=>'senseisaburou@test.com',
            'sex'=>'1',
            'role'=>'3',
            'birth_day'=>'1980-9-9',
            'password'=>bcrypt('sensei789'),
        ]);

        User::create([
            'id'=>'8',
            'over_name'=>'生徒',
            'under_name'=>'松子',
            'over_name_kana'=>'セイト',
            'under_name_kana'=>'マツコ',
            'mail_address'=>'seitomatuko@test.com',
            'sex'=>'2',
            'role'=>'4',
            'birth_day'=>'1999-12-12',
            'password'=>bcrypt('seito890'),
        ]);


    }
}
