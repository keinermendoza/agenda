<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
Route::redirect('/', 'internal')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('internal')->group(function () {
        Route::get('', fn () => redirect()->route('reservas.index'))->name('dashboard');
        Route::resource('reservas', ReservaController::class);
    });
});

require __DIR__.'/settings.php';
