<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=factory(User::class)->times(50)->make();
        User::insert($users->makeVisible(['password','remember_token'])->toArray());
//        第一个用户
        $user=User::first();
        $user->name='bobo';
        $user->email='wangyb65@gmail.com';
        $user->is_admin=true;
        $user->password=Hash::make('123456');
        $user->save();
    }
}
