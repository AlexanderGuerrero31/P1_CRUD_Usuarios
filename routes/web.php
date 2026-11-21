<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Solo administrador: eliminar, papelera y restaurar
Route::middleware(['auth', 'role:admin'])->prefix('users')->name('users.')->group(function () {
    Route::get('/trashed', [UserController::class, 'trashed'])->name('trashed');
    Route::patch('/{id}/restore', [UserController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force', [UserController::class, 'forceDelete'])->name('force');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

// Administrador y empleado: el resto del CRUD
Route::middleware(['auth', 'role:admin,empleado'])->group(function () {
    Route::resource('users', UserController::class)->except(['destroy']);
});

require __DIR__.'/auth.php';
