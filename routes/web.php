<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\FaqCategoryAdminController;
use App\Http\Controllers\Admin\FaqItemAdminController;
use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\ListingAdminController;
use App\Http\Controllers\Admin\DashboardController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');

Route::resource('news', NewsController::class)->only(['index', 'show']);
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/profiles/{user:username}', [ProfileController::class, 'show'])->name('profiles.show');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth-only
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profiles.update');

    // Listings CRUD - specific routes BEFORE dynamic routes
    Route::get('/listings/create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::patch('/listings/{listing}/toggle-sold', [ListingController::class, 'toggleSold'])->name('listings.toggleSold');
    Route::patch('/listings/{listing}/toggle-reserved', [ListingController::class, 'toggleReserved'])->name('listings.toggleReserved');

    // Favorites
    Route::post('/listings/{listing}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/listings/{listing}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // My Listings
    Route::get('/my-listings', function () {
        $listings = auth()->user()->listings()->latest()->get();
        return view('listings.my', compact('listings'));
    })->name('listings.mine');

    // Conversations
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/listings/{listing}/conversations', [ConversationController::class, 'start'])->name('conversations.start');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Public listing show - AFTER /listings/create
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// Admin-only
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserAdminController::class);
    Route::post('/users/{user}/toggle-admin', [UserAdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::resource('news', NewsAdminController::class)->except(['show']);
    Route::resource('faq-categories', FaqCategoryAdminController::class);
    Route::resource('faq-items', FaqItemAdminController::class);
    Route::resource('contact-messages', ContactMessageAdminController::class)->only(['index', 'show', 'destroy']);
    Route::post('/contact-messages/{contactMessage}/reply', [ContactMessageAdminController::class, 'reply'])->name('contact-messages.reply');

    // Listings management
    Route::get('/listings', [ListingAdminController::class, 'index'])->name('listings.index');
    Route::patch('/listings/{listing}/toggle-featured', [ListingAdminController::class, 'toggleFeatured'])->name('listings.toggleFeatured');
    Route::patch('/listings/{listing}/toggle-sold', [ListingAdminController::class, 'toggleSold'])->name('listings.toggleSold');
    Route::patch('/listings/{listing}/toggle-reserved', [ListingAdminController::class, 'toggleReserved'])->name('listings.toggleReserved');
    Route::delete('/listings/{listing}', [ListingAdminController::class, 'destroy'])->name('listings.destroy');
});

require __DIR__.'/auth.php';
