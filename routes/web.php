<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('home');
});

Route::get('/menu', [App\Http\Controllers\MenuController::class, 'index'])
    ->name('menu');

Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])
    ->name('gallery');

Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])
    ->name('about');

Route::get('/blog', [App\Http\Controllers\BlogController::class, 'index'])
    ->name('blog');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])
    ->name('contact');

Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::get('/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/apply-coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [App\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('admin.dashboard');
