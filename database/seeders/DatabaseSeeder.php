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
        // Admin account voor opdracht
        $admin = User::firstOrCreate(
            ['email' => 'admin@ehb.be'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => bcrypt('Password!321'),
                'is_admin' => true,
                'bio' => 'Platform administrator.',
            ]
        );

        // Test gebruikers
        $user1 = User::firstOrCreate(
            ['email' => 'alice@student.ehb.be'],
            [
                'name' => 'Alice Vermeulen',
                'username' => 'alice_v',
                'password' => bcrypt('password'),
                'bio' => 'Second-year student looking for textbooks.',
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'bob@student.ehb.be'],
            [
                'name' => 'Bob Janssens',
                'username' => 'bob_j',
                'password' => bcrypt('password'),
                'bio' => 'Selling my old study materials.',
            ]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'claire@student.ehb.be'],
            [
                'name' => 'Claire De Vos',
                'username' => 'claire_d',
                'password' => bcrypt('password'),
                'bio' => 'Looking for affordable supplies.',
            ]
        );

        $users = collect([$admin, $user1, $user2, $user3]);

        // Categorieën
        $catBooks = Category::firstOrCreate(['name' => 'Books']);
        $catElectronics = Category::firstOrCreate(['name' => 'Electronics']);
        $catFurniture = Category::firstOrCreate(['name' => 'Furniture']);
        $catSports = Category::firstOrCreate(['name' => 'Sports']);
        $catClothing = Category::firstOrCreate(['name' => 'Clothing']);
        $catOther = Category::firstOrCreate(['name' => 'Other']);

        $categories = collect([$catBooks, $catElectronics, $catFurniture, $catSports, $catClothing, $catOther]);

        // Tags voor listings
        $tagNew = Tag::firstOrCreate(['name' => 'New']);
        $tagUsed = Tag::firstOrCreate(['name' => 'Used']);
        $tagNegotiable = Tag::firstOrCreate(['name' => 'Negotiable']);
        $tagUrgent = Tag::firstOrCreate(['name' => 'Urgent']);

        $tags = collect([$tagNew, $tagUsed, $tagNegotiable, $tagUrgent]);

        // Belgische locaties voor test data
        $belgianLocations = [
            ['city' => 'Brussels', 'zip' => '1000', 'lat' => 50.8503, 'lng' => 4.3517],
            ['city' => 'Ghent', 'zip' => '9000', 'lat' => 51.0543, 'lng' => 3.7174],
            ['city' => 'Antwerp', 'zip' => '2000', 'lat' => 51.2194, 'lng' => 4.4025],
            ['city' => 'Leuven', 'zip' => '3000', 'lat' => 50.8798, 'lng' => 4.7005],
            ['city' => 'Bruges', 'zip' => '8000', 'lat' => 51.2093, 'lng' => 3.2247],
            ['city' => 'Mechelen', 'zip' => '2800', 'lat' => 51.0259, 'lng' => 4.4777],
            ['city' => 'Liège', 'zip' => '4000', 'lat' => 50.6326, 'lng' => 5.5797],
            ['city' => 'Namur', 'zip' => '5000', 'lat' => 50.4674, 'lng' => 4.8720],
        ];

        // Listings
        $listingsData = [
            ['title' => 'Marketing Principles Textbook 5th Edition', 'desc' => 'Excellent condition, barely used. Perfect for first-year marketing students.', 'price' => 2500, 'cat' => $catBooks, 'loc' => $belgianLocations[0], 'featured' => true],
            ['title' => 'MacBook Pro 13-inch 2020', 'desc' => 'Great for students. 8GB RAM, 256GB SSD. Battery health 92%.', 'price' => 75000, 'cat' => $catElectronics, 'loc' => $belgianLocations[1], 'featured' => true],
            ['title' => 'Desk Lamp with USB Port', 'desc' => 'Modern LED desk lamp. Adjustable brightness. Includes USB charging port.', 'price' => 1500, 'cat' => $catFurniture, 'loc' => $belgianLocations[2], 'featured' => false],
            ['title' => 'Office Chair - Ergonomic', 'desc' => 'Comfortable ergonomic chair. Lumbar support, adjustable height.', 'price' => 6000, 'cat' => $catFurniture, 'loc' => $belgianLocations[3], 'featured' => true],
            ['title' => 'Scientific Calculator TI-84 Plus', 'desc' => 'Graphing calculator in perfect working condition. Great for math and engineering.', 'price' => 4500, 'cat' => $catElectronics, 'loc' => $belgianLocations[0], 'featured' => false],
            ['title' => 'Winter Jacket - North Face', 'desc' => 'Size M, waterproof, warm. Used one season only.', 'price' => 8000, 'cat' => $catClothing, 'loc' => $belgianLocations[4], 'featured' => false],
            ['title' => 'Basketball Shoes Nike - Size 42', 'desc' => 'Lightly used. Great grip and support for indoor/outdoor.', 'price' => 3500, 'cat' => $catSports, 'loc' => $belgianLocations[1], 'featured' => true],
            ['title' => 'Bike Lock Heavy Duty', 'desc' => 'U-lock with cable extension. Very secure. Keys included.', 'price' => 2000, 'cat' => $catOther, 'loc' => $belgianLocations[5], 'featured' => false],
            ['title' => 'Coffee Machine Nespresso', 'desc' => 'Works perfectly. Includes milk frother. No capsules included.', 'price' => 5500, 'cat' => $catOther, 'loc' => $belgianLocations[2], 'featured' => false],
            ['title' => 'Study Notes - Financial Accounting', 'desc' => 'Complete notes for the entire semester. Clear and organized.', 'price' => 1000, 'cat' => $catBooks, 'loc' => $belgianLocations[6], 'featured' => false],
            ['title' => 'Monitor 24 inch Dell', 'desc' => '1080p IPS display. HDMI and DisplayPort. No dead pixels.', 'price' => 9000, 'cat' => $catElectronics, 'loc' => $belgianLocations[3], 'featured' => false],
            ['title' => 'Backpack - Eastpak', 'desc' => 'Durable backpack with laptop compartment. Slightly worn but functional.', 'price' => 2500, 'cat' => $catOther, 'loc' => $belgianLocations[7], 'featured' => false],
            ['title' => 'Biology Lab Manual 2024', 'desc' => 'Current edition. Unused. Has all experiment protocols.', 'price' => 1800, 'cat' => $catBooks, 'loc' => $belgianLocations[0], 'featured' => false],
            ['title' => 'Wireless Mouse Logitech', 'desc' => 'Ergonomic design. Battery included. Works great.', 'price' => 1200, 'cat' => $catElectronics, 'loc' => $belgianLocations[1], 'featured' => false],
            ['title' => 'Yoga Mat + Weights Set', 'desc' => 'Complete home workout set. Mat + 2x 3kg dumbbells. Barely used.', 'price' => 3000, 'cat' => $catSports, 'loc' => $belgianLocations[4], 'featured' => false],
        ];

        foreach ($listingsData as $data) {
            $listing = Listing::firstOrCreate(
                ['title' => $data['title']],
                [
                    'user_id' => $users->random()->id,
                    'category_id' => $data['cat']->id,
                    'description' => $data['desc'],
                    'price_cents' => $data['price'],
                    'is_sold' => false,
                    'is_featured' => $data['featured'],
                    'location_city' => $data['loc']['city'],
                    'location_zip' => $data['loc']['zip'],
                    'lat' => $data['loc']['lat'],
                    'lng' => $data['loc']['lng'],
                ]
            );

            if ($listing->wasRecentlyCreated) {
                $listing->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->all()
                );
            }
        }

        // Nieuws
        NewsItem::firstOrCreate(
            ['title' => 'Welcome to Student Marketplace'],
            [
                'user_id' => $admin->id,
                'content' => 'Find great deals from fellow students. Buy and sell textbooks, electronics, and more.',
                'published_at' => now(),
            ]
        );

        NewsItem::firstOrCreate(
            ['title' => 'Distance Search Now Available'],
            [
                'user_id' => $admin->id,
                'content' => 'You can now filter listings by distance. Just enter your city, postcode, and radius.',
                'published_at' => now(),
            ]
        );

        // FAQ
        $faqCatGeneral = FaqCategory::firstOrCreate(['name' => 'General']);
        $faqCatSelling = FaqCategory::firstOrCreate(['name' => 'Selling']);
        $faqCatBuying = FaqCategory::firstOrCreate(['name' => 'Buying']);

        FaqItem::firstOrCreate(
            ['question' => 'How do I create a listing?'],
            [
                'faq_category_id' => $faqCatSelling->id,
                'answer' => 'Click "Create listing" in the navigation menu and fill out the form.',
            ]
        );

        FaqItem::firstOrCreate(
            ['question' => 'How do I contact a seller?'],
            [
                'faq_category_id' => $faqCatBuying->id,
                'answer' => 'Click "Message Seller" on any listing page to start a conversation.',
            ]
        );

        FaqItem::firstOrCreate(
            ['question' => 'Is the platform free?'],
            [
                'faq_category_id' => $faqCatGeneral->id,
                'answer' => 'Yes, Student Marketplace is completely free for all students.',
            ]
        );

        FaqItem::firstOrCreate(
            ['question' => 'How does distance search work?'],
            [
                'faq_category_id' => $faqCatBuying->id,
                'answer' => 'Enter your city, postcode, and choose a radius to see listings sorted by distance.',
            ]
        );
    }
}
