<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // Assuming you have at least one user in your database

        Post::create([
            'title' => 'First Post',
            'content' => 'This is the content of the first post.',
            'user_id' => $user->id, // Assign the first user as the author
        ]);

        Post::create([
            'title' => 'Second Post',
            'content' => 'This is the content of the second post.',
            'user_id' => $user->id,
        ]);
    }
}
