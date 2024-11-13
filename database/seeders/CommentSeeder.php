<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        $post = Post::first();

        Comment::create([
            'body' => 'This is a comment on the first blog post.',
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
