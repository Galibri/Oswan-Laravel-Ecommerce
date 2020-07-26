<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'email'    => 'admin@admin.com',
                'password' => bcrypt('password')
            ],
            [
                'email'    => 'user@user.com',
                'password' => bcrypt('password')
            ]
        ]);
    }
}