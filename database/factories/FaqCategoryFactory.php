<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    public function definition(): array
    {
        $names = ['Account', 'Listings', 'Payments', 'Safety', 'Technical'];

        return [
            'name' => $this->faker->unique()->randomElement($names) . ' ' . $this->faker->unique()->numberBetween(1, 20),
        ];
    }
}
