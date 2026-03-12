<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ReservationsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{product}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.detail');
Route::post('/blog/save', [BlogController::class, 'savePost'])->name('blog.save');
Route::get('/vouchers', [MenuController::class, 'vouchers'])->name('vouchers');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/reload', function (Request $request) {
    $to = urldecode((string) $request->query('to', '/'));
    if (Str::startsWith($to, ['http://', 'https://'])) {
        $parsed = parse_url($to);
        $host = $parsed['host'] ?? '';
        if ($host && $host !== $request->getHost()) {
            $to = '/';
        } else {
            $to = ($parsed['path'] ?? '/')
                .(isset($parsed['query']) ? '?'.$parsed['query'] : '')
                .(isset($parsed['fragment']) ? '#'.$parsed['fragment'] : '');
        }
    }
    if (!Str::startsWith($to, '/')) {
        $to = '/';
    }

    return view('reload', ['to' => $to]);
})->name('reload');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::delete('/cart/remove-selected', [CartController::class, 'removeSelected'])->name('cart.removeSelected');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/my-orders', [ProfileController::class, 'myOrders'])->name('my-orders');
    Route::get('/my-orders/{order}', [ProfileController::class, 'myOrderShow'])->name('my-orders.show');
    Route::patch('/my-orders/{order}/cancel', [ProfileController::class, 'cancelMyOrder'])->name('my-orders.cancel');
    Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin,staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])
        ->whereNumber('order')
        ->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->whereNumber('order')
        ->name('admin.orders.updateStatus');

    Route::get('/admin/products', [ProductsController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/{product}', [ProductsController::class, 'show'])
        ->whereNumber('product')
        ->name('admin.products.show');
    Route::post('/admin/products/{product}/stock-in', [ProductsController::class, 'stockIn'])
        ->whereNumber('product')
        ->name('admin.products.stockIn');
    Route::patch('/admin/products/{product}/availability', [ProductsController::class, 'toggleAvailability'])
        ->whereNumber('product')
        ->name('admin.products.toggleAvailability');

    Route::get('/admin/customers', [CustomersController::class, 'index'])->name('admin.customers');
    Route::get('/admin/customers/{customer}', [CustomersController::class, 'show'])
        ->whereNumber('customer')
        ->name('admin.customers.show');

    Route::get('/admin/reservations', [ReservationsController::class, 'index'])->name('admin.reservations');
    Route::patch('/admin/reservations/{reservation}/status', [ReservationsController::class, 'updateStatus'])
        ->whereNumber('reservation')
        ->name('admin.reservations.updateStatus');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/categories', [CategoriesController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/create', [CategoriesController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoriesController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [CategoriesController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [CategoriesController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/products/create', [ProductsController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [ProductsController::class, 'edit'])
        ->whereNumber('product')
        ->name('admin.products.edit');
    Route::put('/admin/products/{product}', [ProductsController::class, 'update'])
        ->whereNumber('product')
        ->name('admin.products.update');
    Route::delete('/admin/products/{product}', [ProductsController::class, 'destroy'])
        ->whereNumber('product')
        ->name('admin.products.destroy');

    Route::get('/admin/customers/create', [CustomersController::class, 'create'])->name('admin.customers.create');
    Route::post('/admin/customers', [CustomersController::class, 'store'])->name('admin.customers.store');
    Route::get('/admin/customers/{customer}/edit', [CustomersController::class, 'edit'])
        ->whereNumber('customer')
        ->name('admin.customers.edit');
    Route::put('/admin/customers/{customer}', [CustomersController::class, 'update'])
        ->whereNumber('customer')
        ->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [CustomersController::class, 'destroy'])
        ->whereNumber('customer')
        ->name('admin.customers.destroy');

    Route::resource('admin/coupons', CouponController::class)->names([
        'index' => 'admin.coupons',
        'create' => 'admin.coupons.create',
        'store' => 'admin.coupons.store',
        'show' => 'admin.coupons.show',
        'edit' => 'admin.coupons.edit',
        'update' => 'admin.coupons.update',
        'destroy' => 'admin.coupons.destroy',
    ]);
    Route::patch('/admin/coupons/{coupon}/status', [CouponController::class, 'toggleStatus'])
        ->whereNumber('coupon')
        ->name('admin.coupons.toggleStatus');

    Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UsersController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users', [UsersController::class, 'storeUser'])->name('admin.users.store');
    Route::patch('/admin/users/{user}/role', [UsersController::class, 'updateUserRole'])->name('admin.users.updateRole');
    Route::patch('/admin/users/{user}/status', [UsersController::class, 'updateUserStatus'])->name('admin.users.updateStatus');
    Route::delete('/admin/users/{user}', [UsersController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::get('/admin/users/roles/create', [UsersController::class, 'createRole'])->name('admin.users.roles.create');
    Route::post('/admin/users/roles', [UsersController::class, 'storeRole'])->name('admin.users.roles.store');
    Route::get('/admin/users/roles/{role}/edit', [UsersController::class, 'editRole'])->name('admin.users.roles.edit');
    Route::put('/admin/users/roles/{role}', [UsersController::class, 'updateRole'])->name('admin.users.roles.update');
    Route::delete('/admin/users/roles/{role}', [UsersController::class, 'destroyRole'])->name('admin.users.roles.destroy');

});

Route::get('/api/revenue-by-month', [DashboardController::class, 'revenueByMonth']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/forgot', [AuthController::class, 'showForgotPasswordForm'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot', [AuthController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset/{token}', [AuthController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');
