<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC (BISA DIAKSES TANPA LOGIN)
|--------------------------------------------------------------------------
*/

// 🔥 HOME → SHOP
Route::get('/', function () {
    return redirect('/shop');
});

// 🔥 SHOP (PUBLIC)
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{id}', [ShopController::class, 'show']);

// 🔥 LOGIN
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// 🔥 LOGOUT
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


/*
|--------------------------------------------------------------------------
| CUSTOMER (LOGIN OPTIONAL)
|--------------------------------------------------------------------------
*/

// 🔥 CART
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart/increase/{key}', [CartController::class, 'increase']);
Route::get('/cart/decrease/{key}', [CartController::class, 'decrease']);
Route::get('/cart/remove/{key}', [CartController::class, 'remove']);

// 🔥 CHECKOUT
Route::get('/checkout', [CartController::class, 'checkout']);
Route::post('/checkout', [CartController::class, 'processCheckout']);


/*
|--------------------------------------------------------------------------
| AUTH (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // 🔥 CUSTOMER ORDERS
    Route::get('/my-orders', [OrderController::class, 'myOrders']);

    // 🔥 PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA (PROTECTED 🔥)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    // 🔥 DASHBOARD ADMIN (PRODUCTS)
    Route::resource('products', ProductController::class);

    // 🔥 ADMIN ORDERS
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // 🔥 UPDATE STATUS
    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);
    // 🔥 SETTINGS (UNTUK ICON ⚙️)
    Route::get('/settings', function () {
        return view('admin.settings');
    });
    Route::get('/notifications', function () {
    return response()->json([
        'count' => \App\Models\Order::where('status','pending')->count(),
        'orders' => \App\Models\Order::latest()->take(5)->get()
    ]);
});

});