<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();
        $status = $this->faker->randomElement(['draft', 'published', 'archived']);
        $createdAt = $this->faker->dateTimeBetween('-1 year', 'now');
        
        return [
            'author_id' => Author::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(rand(3, 7), true),
            'status' => $status,
            'published_at' => $status === 'published' ? $this->faker->dateTimeBetween($createdAt, 'now') : null,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}