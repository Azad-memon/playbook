<?php

use App\Http\Controllers\companyadmin\AdminController;
use App\Http\Controllers\companyadmin\DashboardController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\manager\ManagerDashboardController;
use Illuminate\Support\Facades\Route;


Route::get('/signup/{token}', [AdminController::class, 'showSignupForm'])->name('signup.form');
Route::post('/signup/{token}', [AdminController::class, 'completeSignup'])->name('signup.complete');
// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'user.role:company-admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
     Route::get('profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

});



