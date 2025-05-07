<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\GiftIdeasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoneyController;

Route::get('/register', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
Route::post('/user/register', [AuthController::class, 'register'])->name('register');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.login');
Route::get('/wishlist/{slug}', [WishlistController::class, 'view'])->name('wishlist.view');
Route::get('/', [HomeController::class, 'index']);
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');

Route::post('/donate/initiate', [MoneyController::class, 'initiate'])->name('donate.initiate');
Route::get('/donate/callback', [MoneyController::class, 'callback'])->name('donate.callback');

Route::middleware(['auth'])->group(function () {
   
//wishlist
Route::post('/upload-image/{wishlistId}', [WishlistController::class, 'upload'])->name('upload.image'); // Create wishlist
Route::post('/wishlists', [WishlistController::class, 'store'])->name('create.wishlist'); // Create wishlist
Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlist'); // Get all wishlists
Route::get('/edit-{slug}', [WishlistController::class, 'edit'])->name('wishlist.show'); // Show one wishlist
Route::get('/view-{slug}', [WishlistController::class, 'show'])->name('wishlist.view'); // Show one wishlist
Route::post('/wishlists/{id}', [WishlistController::class, 'update'])->name('update.wishlist'); // Update wishlist
Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy'); // Delete wishlist


// Item Routes
Route::post('/items', [ItemController::class, 'store'])->name('create.item'); // Create item
Route::get('/items/{id}', [ItemController::class, 'show']); // Show one item
Route::post('/items/update/{id}', [ItemController::class, 'update'])->name('items.update'); // Update item
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy'); // Delete item
Route::post('/reservations', [ItemController::class, 'reserve']);

//money 
Route::post('/money', [MoneyController::class, 'store'])->name('create.money'); 
Route::delete('/money/{id}', [MoneyController::class, 'destroy'])->name('money.destroy'); // Delete money


//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Get all wishlists


//bank
Route::get('/banks', [BankController::class, 'getBanks']);
Route::get('/resolve-account', [BankController::class, 'resolveAccount']);
Route::post('/account-details', [BankDetailsController::class, 'store'])->name('account.details.store');
Route::get('/get-user-accounts', [BankDetailsController::class, 'index']);
//gift ideas
Route::post('/generate-gift-ideas', [GiftIdeasController::class, 'generate']);


//wallet 
// Route::post('/withdraw-request', [WalletController::class, 'withdrawRequest'])->name('wallet.withdraw');


//logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});