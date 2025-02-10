<?php

use App\Http\Controllers\PersonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
// });


Route::get('/', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/{person}', [PersonController::class, 'show'])->name('people.show');

Route::middleware('auth')->group(function () {
    Route::get('/peoples/create', [PersonController::class, 'create'])->name('people.create');
    Route::post('/people', [PersonController::class, 'store'])->name('people.store');
});

 
