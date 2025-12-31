<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ListingController;
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
});

// Admin-only
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserAdminController::class);
    Route::resource('news', NewsAdminController::class)->except(['show']);
    Route::resource('faq-categories', FaqCategoryAdminController::class);
    Route::resource('faq-items', FaqItemAdminController::class);
    Route::resource('contact-messages', ContactMessageAdminController::class)->only(['index', 'show', 'destroy']);
});

require __DIR__.'/auth.php';
