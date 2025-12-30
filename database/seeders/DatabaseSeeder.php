<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use App\Models\Listing;
use App\Models\NewsItem;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default admin (REQUIREMENT)
        $admin = User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => 'Password!321',
            'is_admin' => true,
            'bio' => 'Platform administrator.',
        ]);

        // Regular users
        $users = User::factory()->count(10)->create();

        // Categories
        $categories = Category::factory()->count(6)->create();

        // Tags
        $tags = Tag::factory()->count(12)->create();

        // Listings (each belongs to a user + category, attach random tags)
        Listing::factory()
            ->count(25)
            ->state(fn () => [
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
            ])
            ->create()
            ->each(function (Listing $listing) use ($tags) {
                $listing->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')->all()
                );
            });

        // News items (authored by admin)
        NewsItem::factory()
            ->count(6)
            ->state(fn () => [
                'user_id' => $admin->id,
            ])
            ->create();

        // FAQ
        $faqCats = FaqCategory::factory()->count(3)->create();
        foreach ($faqCats as $cat) {
            FaqItem::factory()->count(4)->create([
                'faq_category_id' => $cat->id,
            ]);
        }
    }
}
