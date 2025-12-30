<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition(): array
    {
        $base = [
            'urgent', 'pickup', 'delivery', 'new', 'used', 'cheap', 'premium',
            'bundle', 'negotiable', 'student-proof', 'today', 'limited',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($base) . '-' . $this->faker->unique()->numberBetween(1, 999),
        ];
    }
}
