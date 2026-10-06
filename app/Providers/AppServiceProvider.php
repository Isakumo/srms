<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'active.user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('permission:users.view')->group(function () {
        Route::get('/admin/users', function () {
            return 'Users management placeholder';
        });
    });

    Route::middleware('permission:roles.view')->group(function () {
        Route::get('/admin/roles', function () {
            return 'Roles management placeholder';
        });
    });
});
