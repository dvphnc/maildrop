<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\PayPalController;

Route::get('/', function () {
    return redirect('/send-email');
});

// Email routes
Route::get('/send-email', [EmailController::class, 'index']);
Route::post('/send-email', [EmailController::class, 'send']);

// PayPal routes
Route::post('/paypal/pay', [PayPalController::class, 'createPayment'])->name('paypal.pay');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');