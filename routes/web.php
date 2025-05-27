<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinansaiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // 🏠 Pagrindinis dashboard
    Route::get('/dashboard', [FinansaiController::class, 'index'])->name('dashboard');

    // 💾 Naujo įrašo išsaugojimas (forma POST)
    Route::post('/irasai', [FinansaiController::class, 'store'])->name('irasai.store');

    // 🗑️ Įrašo trynimas (forma DELETE)
    Route::delete('/irasai/{id}', [FinansaiController::class, 'destroy'])->name('irasai.destroy');

    // Redagavimo forma
    Route::get('/irasai/{id}/edit', [FinansaiController::class, 'edit'])->name('irasai.edit');

    // Redagavimo formos išsaugojimas
    Route::put('/irasai/{id}', [FinansaiController::class, 'update'])->name('irasai.update');
});
