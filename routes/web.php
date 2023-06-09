<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\CashInController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/auth/facebook/redirect', [FacebookAuthController::class, 'redirect']);
Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'handleCallback']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/transactions', [TransactionController::class, 'index'])->middleware(['auth', 'verified'])->name('transactions');
Route::post('/send', [DashboardController::class, 'send'])->middleware(['auth', 'verified'])->name('send');
Route::post('/cash-in', [CashInController::class, 'index'])->middleware(['auth', 'verified'])->name('cashin');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', function () {
    return Inertia::render('Users');
})->middleware(['auth'])->name('users');

require __DIR__.'/auth.php';
