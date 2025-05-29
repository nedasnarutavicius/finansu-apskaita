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

    
    Route::get('/dashboard', [FinansaiController::class, 'index'])->name('dashboard');

    
    Route::post('/irasai', [FinansaiController::class, 'store'])->name('irasai.store');

    
    Route::delete('/irasai/{id}', [FinansaiController::class, 'destroy'])->name('irasai.destroy');

    
    Route::get('/irasai/{id}/edit', [FinansaiController::class, 'edit'])->name('irasai.edit');

    
    Route::put('/irasai/{id}', [FinansaiController::class, 'update'])->name('irasai.update');

    Route::get('/statistika', [FinansaiController::class, 'statistika'])->name('statistika');

    Route::get('/eksportuoti-pdf', [FinansaiController::class, 'eksportuotiPDF'])->name('eksportuoti.pdf');
});
