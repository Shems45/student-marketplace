<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NewsItemFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Welcome to the Marketplace!',
            'Safety tips for student trading',
            'New categories added',
            'Platform maintenance update',
            'How to avoid scams',
            'Feature spotlight: Tags',
        ];

        $publishedAt = Carbon::now()->subDays($this->faker->numberBetween(0, 30));

        return [
            // user_id (author) wordt in seeder gezet
            'title' => $this->faker->randomElement($titles),
            'image_path' => null, // later via upload
            'content' => $this->faker->paragraphs(5, true),
            'published_at' => $publishedAt,
        ];
    }
}
