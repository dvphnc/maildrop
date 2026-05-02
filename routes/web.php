<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\PayPalController;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::get('/send-email', [EmailController::class, 'index']);
Route::post('/send-email', [EmailController::class, 'send']);

Route::post('/paypal/pay', [PayPalController::class, 'createPayment'])->name('paypal.pay');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

Route::get('/success', function () {
    return Inertia::render('Success');
})->name('success');
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::delete('/dashboard/{id}', [DashboardController::class, 'destroy']);