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
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');

Route::get('/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

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

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

        // Reports Fix (Tanpa dobel prefix /admin/)
        Route::get('/reports', [TransactionController::class, 'index'])->name('reports');
    });
});

Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);

Route::resource('jabatan', JabatanController::class);
Route::resource('pengurus', PengurusController::class)->parameters([
    'pengurus' => 'pengurus'
]);