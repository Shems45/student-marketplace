<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\NewsAdminController;
use App\Http\Controllers\Admin\FaqCategoryAdminController;
use App\Http\Controllers\Admin\FaqItemAdminController;
use App\Http\Controllers\Admin\ContactMessageAdminController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public
Route::resource('listings', ListingController::class)->only(['index', 'show']);
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

    Route::resource('listings', ListingController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);

    // Conversations
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/listings/{listing}/conversations', [ConversationController::class, 'start'])->name('conversations.start');
    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Admin-only
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserAdminController::class);
    Route::post('/users/{user}/toggle-admin', [UserAdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::resource('news', NewsAdminController::class)->except(['show']);
    Route::resource('faq-categories', FaqCategoryAdminController::class);
    Route::resource('faq-items', FaqItemAdminController::class);
    Route::resource('contact-messages', ContactMessageAdminController::class)->only(['index', 'show', 'destroy']);
});

require __DIR__.'/auth.php';
