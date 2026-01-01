<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $names = [
            'Books', 'Electronics', 'Furniture', 'Clothing', 'Sports', 'Misc',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($names),
        ];
    }
}
