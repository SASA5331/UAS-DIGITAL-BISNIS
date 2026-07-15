<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Diubah dari '/event/1' (statis) menjadi '/events/{event}' (dinamis) -- Pertemuan 9
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Diubah dari '/checkout' (statis, tanpa data) menjadi '/checkout/{event}' (dinamis) -- Pertemuan 10
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

// Halaman antarmuka pembayaran Midtrans Snap -- Pertemuan 11
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');

// Halaman sukses setelah pembayaran -- Pertemuan 11
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// Redirect default Laravel '/login' ke halaman login admin kita -- Pertemuan 8
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // ====== BARU (Pertemuan 8): Rute Login, BEBAS akses, TANPA middleware ======
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ====== BARU (Pertemuan 8): semua rute di bawah ini WAJIB login + role admin ======
    Route::middleware(['auth', 'admin'])->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Events
        Route::resource('events', AdminEventController::class);

        // Transactions
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

        // CRUD Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // CRUD Partners
        Route::resource('partners', PartnerController::class);
    });
});

// Webhook Midtrans -- Pertemuan 12
// Rute ini di luar grup admin karena dipanggil oleh server Midtrans (bukan user login)
// CSRF dikecualikan di app/Http/Middleware/VerifyCsrfToken.php
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);