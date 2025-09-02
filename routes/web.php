<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', [BookingController::class, 'index'])->name('rooms');
Route::post('/booking', [BookingController::class, 'book'])->name('book');
Route::post('/reset', [BookingController::class, 'reset'])->name('reset');
Route::post('/random', [BookingController::class, 'random_book'])->name('random');