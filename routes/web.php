<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\NotificationsController;
// ==========================================
// ROUTE PUBLIC - KHÁCH VÃNG LAI (không cần đăng nhập)
// ==========================================
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
Route::get('/admin/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
Route::post('/admin/orders', [OrderController::class, 'store'])->name('admin.orders.store');
Route::resource('orders', OrderController::class);
Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

Route::get('/admin/customers', [CustomersController::class, 'index'])->name('admin.customers');
Route::get('/admin/coupons', [CouponController::class, 'index'])->name('admin.coupons');
Route::resource('admin/products', ProductsController::class)->names([
    'index' => 'admin.products',
    'create' => 'admin.products.create',
    'store' => 'admin.products.store',
    'show' => 'admin.products.show',
    'edit' => 'admin.products.edit',
    'update' => 'admin.products.update',
    'destroy' => 'admin.products.destroy',
]);

Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
Route::get('/admin/notifications', [NotificationsController::class, 'index'])->name('admin.notifications');


require __DIR__ . '/auth.php';


Route::middleware('auth')->group(function () {
    // Dashboard (có thể theo role sau này)
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
