<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name'     => 'user'.$i,
                'email'    => 'user'.$i.'@stock.com',
                'password' => bcrypt('password'),
            ]);
            $user->bank()->create(['user_id' => $user->id]);
        }
    }
}
