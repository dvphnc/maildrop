<?php

use App\Http\Controllers\EmailController;

Route::get('/', function () {
    return redirect('/send-email');
});

Route::get('/send-email', [EmailController::class, 'index']);
Route::post('/send-email', [EmailController::class, 'send']);