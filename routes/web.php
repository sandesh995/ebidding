<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', [SiteController::class, 'index'])
    ->name('index');
Auth::routes();
Route::get('/home', [SiteController::class, 'home'])
    ->middleware('auth')
    ->name('home');

// Profile
// Profile
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/bids', [ProfileController::class, 'bids'])->name('bids');
    Route::get('/listings', [ProfileController::class, 'listings'])->name('listings');
    Route::get('/edit', [ProfileController::class, 'editProfile'])->name('edit');
    Route::put('/edit', [ProfileController::class, 'updateProfile'])->name('update');
    Route::get('/password', [ProfileController::class, 'password'])->name('password');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

Route::name('front.')->group(function () {
    Route::get('/pages/{page:slug}', [SiteController::class, 'page'])->name('page');
    Route::get('/search', [SiteController::class, 'search'])->name('search');
    Route::get('/listings', [SiteController::class, 'listings'])->name('listings');
    Route::get('/category/{category}', [SiteController::class, 'category'])->name('category');
    Route::get('/listing/{listing}', [SiteController::class, 'listing'])->name('listing');

    // Logged in Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/create', [FrontController::class, 'create'])->name('create');
        Route::post('/create', [FrontController::class, 'store'])->name('store');
        Route::post('/listing/{listing}', [FrontController::class, 'bid'])->name('bid');
        Route::get('/balance', [FrontController::class, 'balance'])->name('balance');
        Route::get('/balance/{balance}', [FrontController::class, 'balanceInfo'])->name('balance.info');
        Route::get('/topup', [FrontController::class, 'topup'])->name('topup');
    });
});

Route::prefix('/admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);
    Route::resource('balances', \App\Http\Controllers\Admin\BalanceController::class)
        ->only(['index', 'create', 'store', 'show']);
    Route::post('listings/{listing}/expire', [\App\Http\Controllers\Admin\ListingController::class, 'forceExpire'])->name('listings.expire');
    Route::get('listings/{listing}/handle', [\App\Http\Controllers\Admin\ListingController::class, 'handle'])->name('listings.handle');
    Route::post('listings/{listing}/handle', [\App\Http\Controllers\Admin\ListingController::class, 'complete'])->name('listings.complete');
    Route::get('listings/search', [\App\Http\Controllers\Admin\ListingController::class, 'search'])->name('listings.search');
    Route::post('listings/{listing}/images', [\App\Http\Controllers\Admin\ListingController::class, 'addImage'])->name('listings.images.store');
    Route::delete('listings/{listing}/images/cover', [\App\Http\Controllers\Admin\ListingController::class, 'removeCover'])->name('listings.images.cover');
    Route::delete('listings/{listing}/images/{media}', [\App\Http\Controllers\Admin\ListingController::class, 'removeImage'])->name('listings.images.destroy');
    Route::resource('listings', \App\Http\Controllers\Admin\ListingController::class);
});
