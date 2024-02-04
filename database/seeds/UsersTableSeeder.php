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
            'id'=>'2',
            'over_name'=>'テスト',
            'under_name'=>'テスト',
            'over_name_kana'=>'テスト',
            'under_name_kana'=>'テスト',
            'mail_address'=>'user@test.com',
            'sex'=>'1',
            'role'=>'1',
            'birth_day'=>'1998-11-2',
            'password'=>'123456',
        ]);

    }
}
