<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User0',
            'email' => 'user0@email.com',
            'password' => Hash::make('asdf'),
        ]);
        User::create([
            'name' => 'User1',
            'email' => 'user@email.com',
            'password' => Hash::make('asdf'),
        ]);
    }
}
