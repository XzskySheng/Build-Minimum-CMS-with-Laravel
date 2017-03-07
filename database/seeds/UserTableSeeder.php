<?php

use Illuminate\Database\Seeder;
use App\User;    //use User Model
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email'    => 'xzswolfly@outlook.com',
            'password' => Hash::make('123456'),
            'nickname' => 'admin',
            'is_admin' => 1,
        ]);
    }
}
