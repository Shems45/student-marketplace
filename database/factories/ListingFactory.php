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

        $locations = [
            ['city' => 'Brussels', 'zip' => '1000', 'lat' => 50.8503, 'lng' => 4.3517],
            ['city' => 'Ghent', 'zip' => '9000', 'lat' => 51.0543, 'lng' => 3.7174],
            ['city' => 'Antwerp', 'zip' => '2000', 'lat' => 51.2194, 'lng' => 4.4025],
            ['city' => 'Leuven', 'zip' => '3000', 'lat' => 50.8798, 'lng' => 4.7005],
        ];

        $location = $this->faker->randomElement($locations);

        $price = $this->faker->optional(0.85)->numberBetween(300, 50000); // cents

        return [
            // user_id, category_id worden in seeder gezet via state()
            'title' => $this->faker->randomElement($titles) . ' - ' . $this->faker->word(),
            'description' => $this->faker->paragraphs(asText: true),
            'price_cents' => $price,
            'image_path' => null, // later via upload
            'is_sold' => $this->faker->boolean(10),
            'location_city' => $location['city'],
            'location_zip' => $location['zip'],
            'lat' => $location['lat'],
            'lng' => $location['lng'],
        ];
    }
}
