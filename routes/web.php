<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EcoNewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DonationController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    return view('landing'); // Update to use landing.blade.php
})->name('home');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/econews', [NewsController::class, 'index'])->name('econews');
Route::get('/econews/category/{id}', [EcoNewsController::class, 'filterByCategory'])->name('econews.filter.category');
Route::get('/econews/tag/{id}', [EcoNewsController::class, 'filterByTag'])->name('econews.filter.tag');
Route::get('/econews/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('econews.detail');

Route::get('/rankings', [UserController::class, 'rankings'])->name('rankings');

Route::middleware(['auth'])->group(function () {
    Route::get('/ecocycle', [\App\Http\Controllers\EcoCycleController::class, 'index'])->name('ecocycle.home');
    Route::post('/ecocycle/store', [\App\Http\Controllers\EcoCycleController::class, 'store'])->name('ecocycle.store');
    Route::get('/ecocycle/{id}', [\App\Http\Controllers\EcoCycleController::class, 'show'])->name('ecocycle.show');
    Route::get('/ecocycle/details/{id}', [\App\Http\Controllers\EcoCycleController::class, 'getDetails'])->name('ecocycle.details');
    Route::put('/ecocycle/update/{id}', [\App\Http\Controllers\EcoCycleController::class, 'update'])->name('ecocycle.update');
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/my-feedbacks', [FeedbackController::class, 'userFeedbacks'])->name('feedbacks.user');
    Route::get('/feedback-page', function () {
        return view('feedback');
    })->name('feedback.page');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedbacks.index'); // Feedback dari pengguna lain
    Route::get('/my-feedback', [FeedbackController::class, 'userFeedbacks'])->name('feedbacks.user'); // Feedback pengguna sendiri
    Route::post('/events/{event}/register', [\App\Http\Controllers\EventRegistrationController::class, 'store'])->name('event.register');
    Route::get('/profile/point-history', [\App\Http\Controllers\UserController::class, 'pointHistory'])->name('profile.pointHistory');
    Route::post('/donations/{donationProgram}/store', [\App\Http\Controllers\DonationController::class, 'store'])->name('donations.store');
    Route::post('/donations/{donationProgram}/donate', [DonationController::class, 'donate'])->name('donations.donate');
    Route::get('/ecogive', [\App\Http\Controllers\DonationProgramController::class, 'userIndex'])->name('ecogive.index');
    Route::get('/ecogive/{donationProgram}', [\App\Http\Controllers\DonationProgramController::class, 'show'])->name('ecogive.show');
});

// Public routes for events
Route::get('/events', [\App\Http\Controllers\EventController::class, 'showPublicEvents'])->name('events.index');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin-dashboard');
    })->name('admin.dashboard'); // Define the admin.dashboard route

    Route::get('/admin/econews', [NewsController::class, 'manage'])->name('admin.econews.manage');
    Route::get('/admin/econews/edit/{id}', [NewsController::class, 'edit'])->name('admin.econews.edit');
    Route::put('/admin/econews/update/{id}', [NewsController::class, 'update'])->name('admin.econews.update');

    Route::get('/admin/tags-categories', function () {
        $tags = \App\Models\Tag::all();
        $categories = \App\Models\Category::all();
        return view('Admin-TagsCategories', compact('tags', 'categories'));
    })->name('admin.tags-categories.manage');

    Route::post('/admin/tags', [\App\Http\Controllers\TagController::class, 'store'])->name('admin.tags.store');
    Route::put('/admin/tags/{id}', [\App\Http\Controllers\TagController::class, 'update'])->name('admin.tags.update');
    Route::delete('/admin/tags/{id}', [\App\Http\Controllers\TagController::class, 'destroy'])->name('admin.tags.destroy');

    Route::post('/admin/categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/admin/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/achievements', [\App\Http\Controllers\AchievementController::class, 'index'])->name('achievements.index');
    Route::get('/admin/achievements/create', [\App\Http\Controllers\AchievementController::class, 'create'])->name('achievements.create');
    Route::post('/admin/achievements', [\App\Http\Controllers\AchievementController::class, 'store'])->name('achievements.store');
    Route::get('/admin/achievements/{achievement}/edit', [\App\Http\Controllers\AchievementController::class, 'edit'])->name('achievements.edit');
    Route::put('/admin/achievements/{achievement}', [\App\Http\Controllers\AchievementController::class, 'update'])->name('achievements.update');
    Route::delete('/admin/achievements/{achievement}', [\App\Http\Controllers\AchievementController::class, 'destroy'])->name('achievements.destroy');

    Route::resource('events', \App\Http\Controllers\EventController::class)->except(['index', 'show', 'create']);

    Route::get('/admin/events', [\App\Http\Controllers\EventController::class, 'index'])->name('admin.events.index');
    Route::post('/admin/events', [\App\Http\Controllers\EventController::class, 'store'])->name('admin.events.store');
    Route::get('/admin/events/{event}/edit', [\App\Http\Controllers\EventController::class, 'edit'])->name('admin.events.edit');
    Route::put('/admin/events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('admin.events.update');
    Route::delete('/admin/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('admin.events.destroy');

    Route::get('admin/econews/create', [EcoNewsController::class, 'create'])->name('admin.econews.create');
    Route::post('admin/econews/store', [EcoNewsController::class, 'store'])->name('admin.econews.store');

    Route::resource('admin/products', \App\Http\Controllers\ProductController::class)->except(['show']);

    Route::get('/admin/store', [\App\Http\Controllers\ProductController::class, 'adminIndex'])->name('admin.store.index');
    Route::post('/admin/store', [\App\Http\Controllers\ProductController::class, 'store'])->name('admin.store.store');
    Route::put('/admin/store/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('admin.store.update');
    Route::delete('/admin/store/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.store.destroy');

    // Routes for Donation Management
    Route::get('/admin/donations', [\App\Http\Controllers\DonationProgramController::class, 'index'])->name('admin.donations.index');
    Route::post('/admin/donations', [\App\Http\Controllers\DonationProgramController::class, 'store'])->name('admin.donations.store');
    Route::put('/admin/donations/{donationProgram}', [\App\Http\Controllers\DonationProgramController::class, 'update'])->name('admin.donations.update');
    Route::delete('/admin/donations/{donationProgram}', [\App\Http\Controllers\DonationProgramController::class, 'destroy'])->name('admin.donations.destroy');
});

Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor-dashboard', function () {
        return view('vendor-dashboard');
    });

    // Vendor self-management routes
    Route::get('/vendor/profile', [\App\Http\Controllers\VendorController::class, 'createOrEdit'])->name('vendor.profile');
    Route::post('/vendor/profile', [\App\Http\Controllers\VendorController::class, 'storeOrUpdate'])->name('vendor.profile.storeOrUpdate');
    Route::get('/vendor/requests', [\App\Http\Controllers\VendorController::class, 'viewRequests'])->name('vendor.requests');
});

Route::middleware(['auth', 'role:Vendor'])->group(function () {
    Route::get('/vendor-dashboard', function () {
        return view('vendor-dashboard');
    });
});

Route::middleware(['auth', 'role:Client'])->group(function () {
    Route::get('/client-dashboard', function () {
        return view('client-dashboard');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/upload-picture', [UserController::class, 'uploadProfilePicture'])->name('profile.uploadPicture');
    Route::post('/profile/deactivate', [UserController::class, 'deactivateAccount'])->name('profile.deactivate');

    Route::get('/store', [\App\Http\Controllers\ProductController::class, 'index'])->name('store.index'); // Merender store.blade.php
    Route::post('/store/{product}/redeem', [\App\Http\Controllers\ProductController::class, 'redeem'])->name('store.redeem');
});
