<?php

use App\Models\Quote;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sales\QuoteController;
use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\QuoteDownloadController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Ajax\CustomerController as AjaxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthenticatedSessionController::class, 'create'])
->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('sales')->group(function(){
        Route::name('sales.')->group(function(){
            Route::resource('customers', CustomerController::class);
            Route::resource('quotes', QuoteController::class);
        });
    });

    Route::prefix('quotes')->group(function(){
        Route::resource('downloads', QuoteDownloadController::class)->only('show');
    });

    Route::prefix('ajax')->group(function(){
        Route::name('ajax.')->group(function(){
            Route::resource('customers', AjaxController::class);
        });
    });


    Route::get('/ajax/customers', [AjaxController::class, 'index']);

});


require __DIR__.'/auth.php';
