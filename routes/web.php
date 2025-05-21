<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\WishlistController as AdminWishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\GiftIdeasController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\WithdrawalController;

Route::get('/register', [AuthController::class, 'index']);
Route::get('/login', [AuthController::class, 'viewLogin'])->name('login');
Route::post('/user/register', [AuthController::class, 'register'])->name('register');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.login');
Route::get('/wishlist/{slug}', [WishlistController::class, 'view'])->name('wishlist.view');
Route::get('/', [HomeController::class, 'index']);
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactUs'])->name('contact.us');
Route::get('/reset-password', [ForgotPasswordController::class, 'index'])->name('reset.password');
Route::get('/reset-password-otp', [ForgotPasswordController::class, 'viewotp']);
Route::post('/reset-password-otp', [ForgotPasswordController::class, 'sendResetEmail'])->name('sendResetEmail');
Route::post('/verify-otp', [ForgotPasswordController::class, 'reset'])->name('reset');
Route::post('/password-reset', [ForgotPasswordController::class, 'passwordReset'])->name('password.reset');
Route::get('/verify-email', [AuthController::class, 'viewEmail'])->name('verify.email');
Route::post('/reset-email-otp', [AuthController::class, 'verifyEmail'])->name('verify-email');



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
Route::put('/profile/update', [AuthController::class, 'update'])->name('user.profile.update');


//bank
Route::get('/banks', [BankController::class, 'getBanks']);
Route::get('/resolve-account', [BankController::class, 'resolveAccount']);
Route::post('/account-details', [BankDetailsController::class, 'store'])->name('account.details.store');
Route::get('/get-user-accounts', [BankDetailsController::class, 'index']);
//gift ideas
Route::post('/generate-gift-ideas', [GiftIdeasController::class, 'generate']);


Route::post('/withdraw-request', [WithdrawalController::class, 'withdrawFunds'])->name('wallet.withdraw');


//logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});


Route::get('/admin/login', [LoginController::class, 'viewLogin'])->name('admin.login');
Route::post('/admin/submit-login', [LoginController::class, 'store'])->name('submit-login');
Route::middleware(AdminMiddleware::class)->group(function () {
    //dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/user', [AdminDashboardController::class, 'user'])->name('admin.user');

    //wishlist
    Route::get('/admin/wishlists', [AdminWishlistController::class, 'index'])->name('wishlists.index');
    Route::get('/admin/items', [AdminWishlistController::class, 'item'])->name('admin.item');
    Route::get('/admin/money-item', [AdminWishlistController::class, 'money'])->name('money.item');

    //setting
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/admin/settings', [SettingController::class, 'store'])->name('edit.settings');


    //logout
    Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
