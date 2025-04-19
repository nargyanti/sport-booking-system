<?php

use App\Http\Controllers\UserBillingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/payment/{schedule}', [UserBillingController::class, 'show'])->name('user.payment.show');
    Route::post('/payment/{schedule}', [UserBillingController::class, 'submitPayment'])->name('user.payment.submit');
});
