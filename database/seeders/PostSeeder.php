<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        Post::create([
            'title' => 'First Blog Post',
            'body' => 'This is the body of the first blog post.',
            'user_id' => $user->id,
        ]);

        
        Post::create([
            'title' => 'Second Blog Post',
            'body' => 'This is the body of the second blog post.',
            'user_id' => $user->id,
        ]);

    }
}
