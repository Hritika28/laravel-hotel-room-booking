<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', [BookingController::class, 'index'])->name('rooms');
Route::post('/booking', [BookingController::class, 'book'])->name('book');
Route::post('/reset', [BookingController::class, 'reset'])->name('reset');
Route::post('/random', [BookingController::class, 'random_book'])->name('random');

Route::get('/run-seeders', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return 'Seeding complete!';
});