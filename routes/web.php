<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengurusController;

/*
|--------------------------------------------------------------------------
| USER / PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Checkout
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Review & Rating -- Soal 1 Fitur 2
Route::post('/events/{event}/review', [ReviewController::class, 'store'])->name('reviews.store');

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// SSO Google -- Soal 1 Fitur 1
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::post('/auth/logout', [SocialiteController::class, 'logout'])->name('auth.logout');

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', AdminEventController::class);
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::resource('partners', PartnerController::class);

        // Kelola Organisasi -- Soal 1 Fitur 3
        Route::resource('organizations', OrganizationController::class)
             ->only(['index', 'store', 'update', 'destroy']);

        // Reports Fix (Tanpa dobel prefix /admin/)
        Route::get('/reports', [TransactionController::class, 'index'])->name('reports');     
    });
});

// Webhook Midtrans
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

// Responsi: Jabatan & Pengurus
Route::resource('jabatan', JabatanController::class);
Route::resource('pengurus', PengurusController::class)->parameters(['pengurus' => 'pengurus']);
