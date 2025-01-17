<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return  redirect('login');
});

Route::get('/dashboard', function () {
    return redirect()->route(('visits.index'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('visits', VisitController::class);
});

require __DIR__ . '/auth.php';
