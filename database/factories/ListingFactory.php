<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Textbook for sale', 'Laptop charger', 'Desk lamp', 'Office chair',
            'Basketball shoes', 'Monitor 24 inch', 'Winter jacket', 'Calculator',
            'Bike lock', 'Coffee machine',
        ];

        $price = $this->faker->optional(0.85)->numberBetween(300, 50000); // cents

        return [
            // user_id, category_id worden in seeder gezet via state()
            'title' => $this->faker->randomElement($titles) . ' - ' . $this->faker->word(),
            'description' => $this->faker->paragraphs(asText: true),
            'price_cents' => $price,
            'image_path' => null, // later via upload
            'is_sold' => $this->faker->boolean(10),
        ];
    }
}
