<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'admin',
                'email'          => 'admin@yopmail.com',
                'password'       => Hash::make('123456'),
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'User',
                'email'          => 'user@yopmail.com',
                'password'       => Hash::make('123456'),
                'remember_token' => null,
            ],

        ];

        User::insert($users);
    }
}
