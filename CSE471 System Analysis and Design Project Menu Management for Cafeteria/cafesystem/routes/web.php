<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard/user', function() {
    return view('dashboards.user');
})->name('dashboard.user');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
Route::get('/dashboard/user', [DashboardController::class, 'userDashboard'])->name('dashboard.user');

// Menu Routes
Route::prefix('menu')->group(function () {
   Route::get('/', [MenuController::class, 'view'])->name('menu.view');
   Route::get('/manage', [MenuController::class, 'manage'])->name('menu.manage');
   Route::get('/add', [MenuController::class, 'add'])->name('menu.add');
   Route::post('/store', [MenuController::class, 'store'])->name('menu.store');
   Route::get('/edit/{item_id}', [MenuController::class, 'edit'])->name('menu.edit');
   Route::put('/update/{item_id}', [MenuController::class, 'update'])->name('menu.update');
   Route::delete('/delete/{item_id}', [MenuController::class, 'delete'])->name('menu.delete');
});

// Cart Routes (Protected by auth:customer middleware)
Route::prefix('cart')->middleware('auth:customer')->group(function () {
    Route::get('/demoAdd', [CartController::class, 'addDemo'])->name('cart.demoAdd');
    Route::get('/view', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/remove', [CartController::class, 'ClearCart'])->name('cart.ClearCart');
    Route::post('/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/add/promo', [CartController::class, 'addPromoCode'])->name('cart.addPromoCode');
    Route::post('/remove/promo', [CartController::class, 'removePromoCode'])->name('cart.removePromoCode');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/payment', [CartController::class, 'payment'])->name('cart.payment');
    Route::get('/PlaceOrderNow', [CartController::class, 'OrderWithoutPayment'])->name('cart.OrderWithoutPayment');
});

// Order Routes
Route::get('/order/track', function () {
    return view('order.track');
})->name('order.track');

Route::get('/order/incoming', [ManagerController::class, 'viewIncomingOrders'])->name('order.incoming');
Route::get('/order/update', [ManagerController::class, 'viewOrderStatus'])->name('order.update');
Route::post('/order/update/{order_id}', [ManagerController::class, 'updateOrderStatus'])->name('order.updateStatus');
Route::get('/order/track', [ManagerController::class, 'trackOrder'])
    ->middleware('auth:customer')
    ->name('order.track');

// Item Routes
Route::get('/items/unavailable', [ManagerController::class, 'viewMenuAvailability'])->name('items.unavailable');
Route::post('/items/update/{item_id}', [ManagerController::class, 'updateAvailability'])->name('items.availability');

Route::get('/items/highlight', [ManagerController::class, 'viewHighlights'])->name('items.highlight');
Route::post('/items/toggle/{item_id}', [ManagerController::class, 'toggleHighlight'])->name('items.highlights');

// Revenue and Promotions Routes
Route::get('/revenue/daily', function () {
    return view('revenue.daily');
})->name('revenue.daily');

Route::get('/promotions/add', function () {
    return view('promotions.add');
})->name('promotions.add');

// Auth Check Route
Route::get('/authCheck', function() {
    if (Auth::guard('customer')->check()) {
        return 'Authenticated';
    } else {
        return 'Not Authenticated';
    }
});