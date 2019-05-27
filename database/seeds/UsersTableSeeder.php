<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'TestUser',
            'email' => 'user@test.com',
            'password' => Hash::make('user'),
            'isAdmin' => true
        ]);
        User::create([
            'name' => 'TestArtiste',
            'email' => 'artiste@test.com',
            'password' => Hash::make('artiste'),
            'isArtiste' => true
        ]);
    }
}
