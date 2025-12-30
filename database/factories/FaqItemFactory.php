<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqItemFactory extends Factory
{
    public function definition(): array
    {
        $questions = [
            'How do I create an account?',
            'How do I edit my profile?',
            'How do I post a listing?',
            'Can I delete my listing?',
            'How do tags work?',
            'How can I stay safe when meeting someone?',
            'Is payment handled by the platform?',
            'How do I report suspicious behavior?',
        ];

        return [
            // faq_category_id wordt in seeder gezet
            'question' => $this->faker->randomElement($questions),
            'answer' => $this->faker->sentences(3, true),
        ];
    }
}
