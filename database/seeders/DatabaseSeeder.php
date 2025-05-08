<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 authors
        Author::factory(10)->create()->each(function ($author) {
            // Each author has 3-7 posts
            $author->posts()->saveMany(
                Post::factory()->count(rand(3, 7))->make([
                    'author_id' => $author->id
                ])
            );
        });
    }
}
